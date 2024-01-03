<?php
declare( strict_types=1 );


namespace App\Security;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessTokenInterface;

class Auth0ResourceOwner implements ResourceOwnerInterface {
	public function __construct(
		protected array $response,
		protected AccessTokenInterface $token
	) {
	}

	/**
	 * @inheritDoc
	 */
	public function getId() {
		return 'ID';
	}

	/**
	 * @inheritDoc
	 */
	public function toArray() {
		return $this->response;
	}
}