<?php

namespace Application\Auth\RegisterUser;

use Domain\AuthContext\Entity\User;

class RegisterUserCommandResponse
{
    public function __construct(
        public readonly string $status,
        public readonly string $message,
        public readonly ?User $user = null
    ) {
    }
}
