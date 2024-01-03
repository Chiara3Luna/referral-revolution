<?php
declare( strict_types=1 );


namespace App\Security;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Auth0Provider extends AbstractProvider {

	use BearerAuthorizationTrait;

	protected string $domain;

	public function __construct(
		string $domain,
		string $clientId,
		string $clientSecret
	) {
		parent::__construct( [
			'domain'       => $domain,
			'clientId'     => $clientId,
			'clientSecret' => $clientSecret
		] );
	}

	public function getClientId(): string {
		return $this->clientId;
	}

	public function getOIDCLogoutUrl() {
		return "https://{$this->domain}/oidc/logout";
	}

	public function getBaseAuthorizationUrl() {
		return "https://{$this->domain}/authorize";
	}

	public function getBaseAccessTokenUrl( array $params ) {
		return "https://{$this->domain}/oauth/token";
	}

	public function getResourceOwnerDetailsUrl( AccessToken $token ) {
		return "https://{$this->domain}/userinfo";
	}

	protected function getDefaultScopes() {
		return [ 'openid', 'profile', 'email' ];
	}

	protected function checkResponse( ResponseInterface $response, $data ) {
		if ( $response->getStatusCode() >= 400 ) {
			throw new IdentityProviderException( (string) $response->getBody(), $response->getStatusCode(), $response );
		}
	}

	protected function createResourceOwner( array $response, AccessToken $token ) {
		return new Auth0ResourceOwner( $response, $token );
	}

	protected function getScopeSeparator() {
		return ' ';
	}
}