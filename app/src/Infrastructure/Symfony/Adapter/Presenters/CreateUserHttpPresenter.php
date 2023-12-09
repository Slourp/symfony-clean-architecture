<?php

namespace Infrastructure\Symfony\Adapter\Presenters;

use Application\Auth\RegisterUser\CreateUserOutputPort;
use Application\Auth\RegisterUser\RegisterUserCommandResponse;
use Infrastructure\Symfony\Adapter\View\TwigViewModel;
use Twig\Environment;

class CreateUserHttpPresenter implements CreateUserOutputPort
{
    public function __construct(private Environment $renderEngine)
    {
    }

    public function present(RegisterUserCommandResponse $response): TwigViewModel
    {
        return match ($response->status) {
            "USER_CREATED" => $this->userCreated($response),
            "USER_ALREADY_EXISTS" => $this->userAlreadyExists($response),
            "UNABLE_TO_CREATE_USER" => $this->unableToCreateUser($response),
            default => throw new \InvalidArgumentException("Invalid status"),
        };
    }

    public function userCreated(RegisterUserCommandResponse $response): TwigViewModel
    {
        return new TwigViewModel(
            $this->renderEngine,
            'user/show.html.twig',
            [
                'user' => $response->user->getEmail()->value
            ]
        );
    }

    public function userAlreadyExists(RegisterUserCommandResponse $response): TwigViewModel
    {
        return new TwigViewModel(
            $this->renderEngine,
            'user/show.html.twig',
            [
                'user' => $response->message,
                'error' => $response->message
            ]
        );
    }

    public function unableToCreateUser(RegisterUserCommandResponse $response): TwigViewModel
    {
        return new TwigViewModel(
            $this->renderEngine,
            'user/error.html.twig',
            [
                'user' => $response,
                'error' => $response->message
            ]
        );
    }
}
