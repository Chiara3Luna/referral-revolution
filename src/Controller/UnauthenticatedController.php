<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UnauthenticatedController extends AbstractController {
	#[Route( '/', name: 'app_unauthenticated' )]
	public function index(): Response {
		return $this->render( 'unauthenticated/index.html.twig', [
			'controller_name' => 'UnauthenticatedController',
			'event'           => [
				'title' => 'Referral Revolution'
			],
			'login_url' => $this->generateUrl( 'app_dashboard')
		] );
	}
}
