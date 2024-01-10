<?php

namespace App\Controller\BFF;

use Psr\Clock\ClockInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SessionInfo extends AbstractController {

	public function __construct(
		private readonly Security $security
	) {
	}

	#[Route('/.well-known/bff-sessioninfo', name: 'bff_sessioninfo')]
	public function index( Request $request ): JsonResponse|Response {

		if ( ! $this->security->isGranted( 'IS_AUTHENTICATED_FULLY' ) ) {
			return new Response( 'Unauthorized', 401 );
		}

		$session = $request->getSession();
		if ( ! $session ) {
			return new JsonResponse( data: [
				'error'             => 'backend_not_ready',
				'error_description' => ' No session'
			], status: 400 );
		}

		$idToken = $session->get( 'id_token', false );
		if ( $idToken === false ) {
			return new JsonResponse( data: [
				'error'             => 'backend_not_ready',
				'error_description' => ' No token present in session'
			], status: 400 );
		}

		$access_token = $session->get( 'access_token', false );
		if ( $access_token === false ) {
			return new JsonResponse( data: [
				'error'             => 'backend_not_ready',
				'error_description' => ' No token present in session'
			], status: 400 );
		}

		$idToken['payload']['roles'] = $access_token['payload']['services.metodomerenda.com/roles'];

		return new JsonResponse($idToken['payload'], 200);
	}
}