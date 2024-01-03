<?php
declare( strict_types=1 );


namespace App\Security;

use Jose\Component\Core\JWKSet;
use Jose\Component\Signature\JWSLoader;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\Security\Core\Exception\SessionUnavailableException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\AccessToken\AccessTokenHandlerInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\HttpUtils;

class Auth0Authenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface, AccessTokenHandlerInterface, UserProviderInterface {

	private const AUDIENCE = 'https://referral.metodomerenda.com';

	private const SCOPES = [
		'openid',
		'profile',
//		'email',
//		'offline_access'
	];

	public function __construct(
		private readonly JWSLoader $auth0JwsLoader,
		private readonly JWKSet $auth0KeySet,
		private readonly Auth0Provider $provider,
		private readonly HttpUtils $httpUtils,
		private readonly UrlGeneratorInterface $urlGenerator
	) {
	}

	/**
	 * @inheritDoc
	 */
	public function start( Request $request, AuthenticationException $authException = null ): Response {

		$authorizationUrl = $this->provider->getAuthorizationUrl( [
			'redirect_uri' => $this->httpUtils->generateUri( $request, '/_oauth2' ),
			'audience'     => self::AUDIENCE,
			'scope'        => self::SCOPES,
			'auth0_client' => base64_encode( '{ "name":"referral-revolution", "version":"0.0.1" }' )
		] );

		$request->getSession()->set( '_oauth2_state', $this->provider->getState() );

		return new RedirectResponse(
			$authorizationUrl
		);
	}

	/**
	 * @inheritDoc
	 */
	public function supports( Request $request ): ?bool {
		return $this->httpUtils->checkRequestPath( $request, '/_oauth2' );
	}

	/**
	 * @inheritDoc
	 */
	public function authenticate( Request $request ): Passport {
		$sessionState = $request->getSession()->remove( '_oauth2_state' );
		$state        = $request->get( 'state' );
		$code         = $request->get( 'code' );

		if ( ! $sessionState ) {
			throw new SessionUnavailableException();
		}

		if ( ! $state ) {
			throw new BadRequestHttpException( 'Missing state parameter' );
		}

		if ( ! $code ) {
			throw new BadRequestHttpException( 'Missing code parameter' );
		}

		if ( $sessionState !== $state ) {
			throw new BadCredentialsException();
		}

		$token = $this->provider->getAccessToken(
			'authorization_code',
			[
				'code'         => $code,
				'redirect_uri' => $this->httpUtils->generateUri( $request, '/_oauth2' ),
				'audience'     => self::AUDIENCE,
				'scope'        => self::SCOPES
			]
		);

		$values = $token->getValues();
		if ( isset( $values['id_token'] ) ) {
			try {
				$idToken = $this->auth0JwsLoader->loadAndVerifyWithKeySet( $values['id_token'], $this->auth0KeySet, $signature );

				$request->getSession()->set( 'id_token', $values['id_token'] );

				$payload = json_decode( $idToken->getPayload(), true );
				$request->getSession()->set( 'id_token_payload', $payload );

			} catch ( \Throwable $e ) {
				throw new BadCredentialsException( message: 'Invalid ID token.', previous: $e );
			}
		}

		$request->getSession()->set( 'refresh_token', $token->getRefreshToken() );

		try {
			$accessToken = $this->auth0JwsLoader->loadAndVerifyWithKeySet( $token->getToken(), $this->auth0KeySet, $signature );

			$request->getSession()->set( 'access_token', $token->getToken() );

			$payload = json_decode( $accessToken->getPayload(), true );
			$request->getSession()->set( 'access_token_payload', $payload );

			return new SelfValidatingPassport( new UserBadge( $payload['sub'], fn( $identifier ) => $this->loadUserFromAccessToken( $payload ) ) );
		} catch ( \Throwable $e ) {
			throw new BadCredentialsException( message: 'Invalid credentials.', previous: $e );
		}
	}

	/**
	 * @inheritDoc
	 */
	public function onAuthenticationSuccess( Request $request, TokenInterface $token, string $firewallName ): ?Response {
		return new RedirectResponse(
			$this->urlGenerator->generate( 'app_dashboard' )
		);
	}

	/**
	 * @inheritDoc
	 */
	public function onAuthenticationFailure( Request $request, AuthenticationException $exception ): ?Response {
		return new RedirectResponse(
			$this->urlGenerator->generate( 'app_unauthenticated' )
		);
	}

	public function getUserBadgeFrom( #[\SensitiveParameter] string $accessToken ): UserBadge {
		try {
			$jws     = $this->auth0JwsLoader->loadAndVerifyWithKeySet( $accessToken, $this->auth0KeySet, $signature );
			$payload = json_decode( $jws->getPayload(), true );

			return new UserBadge( userIdentifier: $payload['sub'], userLoader: fn( string $identifier ) => $this->loadUserFromBearerToken( $payload ) );

		} catch ( \Throwable $throwable ) {
			throw new BadCredentialsException( message: 'Invalid credentials.', previous: $throwable );
		}
	}

	private function loadUserFromBearerToken( array $token ): UserInterface {

		$userRoles = $this->mapScope( $token['scope'] );

		$userRoles[] = 'ROLE_MACHINE';

		return new User( $token['sub'], $userRoles );
	}

	private function loadUserFromAccessToken( array $token ): UserInterface {
		$userRoles = $this->mapPermissions( $token['permissions'] );

		$userRoles[] = 'ROLE_USER';

		return new User( $token['sub'], $userRoles );
	}

	/**
	 * @return string[]
	 */
	private function mapScope( string $scope ): array {
		return array_map(
			fn( string $scope ) => preg_replace(
				'/[^A-Z0-9]/',
				'_',
				strtoupper( $scope )
			),
			explode( ' ', $scope )
		);
	}

	private function mapPermissions( array $permissions ): array {
		return array_unique(
			array_map(
				fn( string $permission ) => 'ROLE_' . preg_replace(
					'/[^A-Z0-9]/',
					'_',
					strtoupper( $permission )
				),
				$permissions
			)
		);
	}


	public function refreshUser( UserInterface $user ) {
		return $user;
	}

	public function supportsClass( string $class ) {
		return $class === User::class;
	}

	public function loadUserByIdentifier( string $identifier ): UserInterface {
		throw new LogicException( 'Cannot load user' );
	}
}