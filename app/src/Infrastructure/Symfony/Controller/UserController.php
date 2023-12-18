<?php

namespace Infrastructure\Symfony\Controller;

use Application\Auth\RegisterUser\RegisterUserCommand;
use Application\Auth\RegisterUser\RegisterUserInput;
use Infrastructure\Symfony\Adapter\Presenters\CreateUserJsonPresenter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function registerUser(Request $request): Response
    {
        $command = new RegisterUserCommand(
            username: 'username',
            email: $request->get('email'),
            password: $request->get('password')
        );

        $response = $this->input->registerUser($command);

        $view = $this->output->present($response);

        return $view->getResponse();
    }
}
