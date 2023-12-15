<?php

use Application\Auth\RegisterUser\RegisterUserCommand;
use Domain\AuthContext\Exceptions\InvalidEmailException;
use Domain\AuthContext\Exceptions\InvalidPasswordException;
use Domain\AuthContext\Exceptions\InvalidUserNameException;
use Tests\Unit\AuthContext\Fixture\RegisterUserFixture;

beforeEach(function () {
    $this->fixture = new RegisterUserFixture();
});

describe("Feature: Registering a new user", function () {

    describe("Scenario: Correct Registration", function () {
        it('can register user correctly', function () {
            $command = new RegisterUserCommand(
                username: 'username',
                email: 'user@example.com',
                password: "password123AAa12*",
                id: 122,
            );
            $this->fixture->whenUserRegisters($command);

            $this->fixture->thenUserShouldBeRegistered('username');
        });
    });
    // describe("Scenario: Incorrect Registration - No username", function () {
    //     it('throws an error when username is not provided', function () {
    //         $command = new RegisterUserCommand(
    //             username: '',  // username not provided 
    //             email: 'user@example.com',
    //             password: "password123AAa12*",
    //             id: 122,
    //         );

    //         $this->fixture->whenUserRegisters($command);

    //         $this->fixture->thenErrorShouldBe(InvalidUserNameException::class);
    //     });
    // });
    // describe("Scenario: Incorrect Registration - Invalid email", function () {
    //     it('throws an error when email is invalid', function () {
    //         $command = new RegisterUserCommand(
    //             username: 'username',
    //             email: 'invalid email', // invalid email address
    //             password: "password123AAa12*",
    //             id: 122,
    //         );

    //         $this->fixture->whenUserRegisters($command);

    //         $this->fixture->thenErrorShouldBe(InvalidEmailException::class);
    //     });
    // });
    // describe("Scenario: Incorrect Registration - Invalid password", function () {
    //     it('throws an error when password is invalid', function () {
    //         $command = new RegisterUserCommand(
    //             username: 'username',
    //             email: 'user@example.com',
    //             password: "invalidpassword",
    //             id: 122,
    //         );

    //         $this->fixture->whenUserRegisters($command);

    //         $this->fixture->thenErrorShouldBe(InvalidPasswordException::class);
    //     });
    // });
});
