<?php

namespace Infrastructure\Symfony\Adapter\Presenters;

use Application\Auth\RegisterUser\CreateUserOutputPort;
use Application\Auth\RegisterUser\RegisterUserCommandResponse;
use Infrastructure\Symfony\Adapter\View\JsonViewModel;
use Symfony\Component\HttpFoundation\Response;

class CreateUserJsonPresenter implements CreateUserOutputPort
{
    public function present(RegisterUserCommandResponse $response): JsonViewModel
    {
        return match ($response->status) {
            "USER_CREATED" => $this->userCreated($response),
            "USER_EXISTS" => $this->userAlreadyExists($response),
            "UNABLE_TO_CREATE_USER" => $this->unableToCreateUser($response),
            default => throw new \InvalidArgumentException("Invalid status"),
        };
    }

    public function userCreated(RegisterUserCommandResponse $response): JsonViewModel
    {
        return new JsonViewModel(
            Response::HTTP_CREATED,
            [
                'status' => 'success',
                'user' => $response->user->getEmail()->value
            ]
        );
    }

    public function userAlreadyExists(RegisterUserCommandResponse $response): JsonViewModel
    {
        return new JsonViewModel(
            statusCode: Response::HTTP_CONFLICT,
            data: [
                'status' => 'error',
                'error' => $response->message
            ]
        );
    }

    public function unableToCreateUser(RegisterUserCommandResponse $response): JsonViewModel
    {
        return new JsonViewModel(
            statusCode: Response::HTTP_INTERNAL_SERVER_ERROR,
            data: [
                'status' => 'error',
                'error' => $response->message
            ]
        );
    }
}
