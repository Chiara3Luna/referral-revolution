<?php

namespace App\Controller\BFF;

use Psr\Clock\ClockInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class Token extends AbstractController {


	public function __construct(
		private readonly ClockInterface $clock,
		private readonly Security $security
	) {
	}

	#[Route( '/.well-known/bff-token', name: 'bff_token' )]
	public function index( Request $request ) {

		if(!$this->security->isGranted( 'IS_AUTHENTICATED_FULLY')) {
			return new Response('Unauthorized', 401);
		}

		$session = $request->getSession();
		if ( ! $session ) {
			return new JsonResponse( data: [
				'error'             => 'backend_not_ready',
				'error_description' => ' No session'
			], status: 400 );
		}

		$access_token = $session->get( 'access_token', false );
		if ( $access_token === false ) {
			return new JsonResponse( data: [
				'error'             => 'backend_not_ready',
				'error_description' => ' No token present in session'
			], status: 400 );
		}

		return new JsonResponse(
			[
				'access_token' => $access_token['access_token'],
				'expires_in'   => $access_token['payload']['exp'] - $this->clock->now()->getTimestamp(),
				'scope'        => $access_token['payload']['scope']
			],
			200
		);
	}
}