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
            email: '123@test.com',
            password: "password123AAa12*"
        );
        /**
         * @var \Infrastructure\Symfony\Adapter\View\TwigViewModel
         */
        $view = $this->output->present($this->input->registerUser($command));

        return $view->getResponse();
    }
}
