<?php

namespace App\Security;

use App\Exception\Security\InvalidScopeException;
use App\Exception\Security\MissingScopeException;
use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface {

	public function __construct(
		private string $identifier,
		private array $roles
	) {
	}

	public function getRoles(): array {
		return $this->roles;
	}

	public function eraseCredentials() {
	}

	public function getUserIdentifier(): string {
		return $this->identifier;
	}
	
	public function __serialize(): array {
		return [ 'identifier' => $this->identifier, 'roles' => $this->roles ];
	}

	public function __unserialize( array $data ): void {
		[ 'identifier' => $this->identifier, 'roles' => $this->roles] = $data;
	}
}
