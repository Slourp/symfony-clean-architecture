<?php

namespace Infrastructure\Symfony\Adapter\Presenters;


use Application\Auth\RegisterUser\CreateUserOutputPort;
use Application\Auth\RegisterUser\RegisterUserCommandResponse;
use Infrastructure\Symfony\Adapter\View\CliViewModel;
use Symfony\Component\Console\Command\Command;

class CreateUserCliPresenter implements CreateUserOutputPort
{
    public function present(RegisterUserCommandResponse $response): CliViewModel
    {
        return match ($response->status) {
            "USER_CREATED" => $this->userCreated($response),
            "USER_EXISTS" => $this->userAlreadyExists($response),
            "UNABLE_TO_CREATE_USER" => $this->unableToCreateUser($response),
            default => throw new \InvalidArgumentException("Invalid status"),
        };
    }

    public function userCreated(RegisterUserCommandResponse $response): CliViewModel
    {
        return new CliViewModel(function () use ($response) {
            return [
                'message' => "User {$response->user->getEmail()->value} successfully created.",
                'status_code' => Command::SUCCESS,
            ];
        });
    }

    public function userAlreadyExists(RegisterUserCommandResponse $response): CliViewModel
    {
        return new CliViewModel(function () use ($response) {
            return [
                'message' => "User {$response->user->getEmail()->value} already exists!",
                'status_code' => Command::FAILURE,
            ];
        });
    }

    public function unableToCreateUser(RegisterUserCommandResponse $response): CliViewModel
    {
        return new CliViewModel(function () use ($response) {
            return [
                'message' => "Error occurred while creating user: {$response->message}",
                'status_code' => Command::FAILURE,
            ];
        });
    }
}
