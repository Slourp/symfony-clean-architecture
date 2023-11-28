<?php

namespace Infrastructure\Symfony\Controller;

use Application\Auth\RegisterUser\RegisterUserCommand;
use Application\Auth\RegisterUser\RegisterUserInput;
use Infrastructure\Symfony\Adapter\Presenters\CreateUserJsonPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function __construct(
        private RegisterUserInput $input,
        private CreateUserJsonPresenter $output,
    ) {
    }

    #[Route('/api/register', name: 'api_register', methods: ['GET'])]
    public function registerUser(): Response
    {
        $command = new RegisterUserCommand(
            username: 'username',
            email: $this->generateRandomEmail(),
            password: "password123AAa12*"
        );

        $response = $this->input->registerUser($command);

        $view = $this->output->present($response);

        return $view->getResponse();
    }

    private function generateRandomEmail($length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $emailAddress = '';
        for ($i = 0; $i < $length; $i++) {
            $emailAddress .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $emailAddress . '@example.com';
    }
}
