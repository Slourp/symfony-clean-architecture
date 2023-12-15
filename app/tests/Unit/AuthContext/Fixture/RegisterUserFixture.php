<?php

namespace Tests\Unit\AuthContext\Fixture;

use Application\Auth\RegisterUser\RegisterUserCommand;
use Application\Auth\RegisterUser\RegisterUserCommandHandler;
use Application\Auth\RegisterUser\RegisterUserInput;
use Tests\Unit\AuthContext\Repository\InMemoryUserRepository;

class RegisterUserFixture
{
    /**
     * @var RegisterUserCommandHandler
     */
    private RegisterUserInput $registerUser;
    private InMemoryUserRepository $repository;
    private ?\Throwable $error = null;

    public function __construct()
    {
        $this->repository = new InMemoryUserRepository();

        $this->registerUser = new RegisterUserCommandHandler($this->repository);
    }

    public function whenUserRegisters(RegisterUserCommand $command): void
    {
        try {
            $this->registerUser->registerUser($command);
            $this->error = $this->registerUser->error;
        } catch (\Throwable $e) {
            $this->error = $e;
        }
    }

    public function thenErrorShouldBe(string $expectedError): void
    {
        expect(get_class($this->error))->toBe($expectedError);
    }

    public function thenUserShouldBeRegistered(string $username): void
    {
        $user = $this->repository->findByUsername($username);
        expect($user->getUserName()->value)->toBe($username, "The registered user's username does not match the expected value");
    }
}
