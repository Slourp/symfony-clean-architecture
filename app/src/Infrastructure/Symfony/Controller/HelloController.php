<?php

namespace Infrastructure\Symfony\Controller;

use Application\Auth\RegisterUser\CreateUserOutputPort;
use Application\Auth\RegisterUser\RegisterUserCommand;
use Application\Auth\RegisterUser\RegisterUserInput;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloController extends AbstractController
{
    public function __construct(
        protected RegisterUserInput $input,
        protected CreateUserOutputPort $output,
    ) {
    }

    #[Route('/hello', name: 'app_hello')]
    public function index(): Response
    {

        $command = new RegisterUserCommand(
            username: 'username',
            email: $this->generateRandomEmail(),
            password: "password123AAa12*"
        );

        /**
         * @var \Infrastructure\Symfony\Adapter\View\TwigViewModel
         */
        $view = $this->output->userCreated($this->input->registerUser($command));

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
