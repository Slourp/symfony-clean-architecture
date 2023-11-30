<?php

use Application\Auth\RegisterUser\RegisterUserCommand;
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
});
