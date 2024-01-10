<?php
declare( strict_types=1 );


namespace App\Controller;

use App\Security\Auth0Provider;
use League\Uri\Uri;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[AsController]
class OAuth2Controller {

	public function __construct(
		private readonly Security $security,
		private readonly Auth0Provider $auth0Provider,
		private readonly UrlGeneratorInterface $urlGenerator
	) {
	}

	#[Route('/_oauth2', 'oauth2_callback')]
	public function oauth2() {
	}

	#[Route('/logout', 'logout')]
	public function logout(Request $request): RedirectResponse {

		$logoutUrl  = $this->urlGenerator->generate( 'app_unauthenticated', [], UrlGeneratorInterface::ABSOLUTE_URL );

		if($this->security->isGranted('IS_AUTHENTICATED')) {
			$template  = $this->auth0Provider->getOIDCLogoutUrl() . '{?id_token_hint,client_id,post_logout_redirect_uri}';
			$variables = [
				'client_id'                => $this->auth0Provider->getClientId(),
				'post_logout_redirect_uri' => $logoutUrl
			];

			if ( $request->hasSession() ) {
				$idToken = $request->getSession()->get( 'id_token' );

				$variables['id_token_hint'] = $idToken['id_token'];
			}
			$this->security->logout( false );

			$logoutUrl = Uri::fromTemplate( $template, $variables )->toString();

		}

		return new RedirectResponse( $logoutUrl );
	}
}