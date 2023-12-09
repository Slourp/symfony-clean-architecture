<?php

namespace Application\Auth\RegisterUser;

use Domain\AuthContext\Entity\User;
use Domain\AuthContext\Gateway\UserRepositoryWriteI;
use Domain\AuthContext\ValueObject\Email;
use Domain\AuthContext\ValueObject\Password;
use Domain\AuthContext\ValueObject\UserName;


class RegisterUserCommandHandler implements RegisterUserInput
{
    private const STATUS_USER_ALREADY_EXISTS = 'USER_ALREADY_EXISTS';
    private const STATUS_USER_CREATED = 'USER_CREATED';
    private const STATUS_UNABLE_TO_CREATE_USER = 'UNABLE_TO_CREATE_USER';

    public function __construct(
        protected UserRepositoryWriteI $userRepositoryWrite
    ) {
    }

    public function registerUser(RegisterUserCommand $command): RegisterUserCommandResponse
    {
        if ($this->userRepositoryWrite->emailExists(Email::of($command->email))) {
            return new RegisterUserCommandResponse(self::STATUS_USER_ALREADY_EXISTS, 'A user with this email already exists', null);
        }

        try {
            $user = new User(
                userName: UserName::of($command->username),
                email: Email::of($command->email),
                password: Password::of($command->password),
                id: $command?->id
            );
            $this->userRepositoryWrite->registerUser(user: $user);

            return new RegisterUserCommandResponse(self::STATUS_USER_CREATED, 'User is successfully created', $user);
        } catch (\Exception $e) {
            return new RegisterUserCommandResponse(self::STATUS_UNABLE_TO_CREATE_USER, $e->getMessage(), null);
        }
    }
}
