<?php

namespace Infrastructure\Symfony\Command;

use Application\Auth\RegisterUser\CreateUserOutputPort;
use Application\Auth\RegisterUser\RegisterUserCommand as RegisterUser;
use Application\Auth\RegisterUser\RegisterUserInput;
use Infrastructure\Symfony\Adapter\View\CliViewModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'createrun',
    description: 'Creates a new user.'
)]
class CreateUserCommand extends Command
{
    /**
     * @param \Infrastructure\Symfony\Adapter\Presenters\CreateUserCliPresenter @output
     */
    public function __construct(
        private RegisterUserInput $input,
        private CreateUserOutputPort $outputCli,
        string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setName('create:run') // Set command name here

            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $command = new RegisterUser(
            username: 'username',
            email: $this->generateRandomEmail(10),
            password: "password123AAa12*"
        );

        $response = $this->input->registerUser($command);

        /**
         * @var CliViewModel
         */
        $viewModel = $this->outputCli->present($response);

        return $viewModel->getResponse();
    }

    private function generateRandomEmail($length = 10): string
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $emailAddress = '';
        for ($i = 0; $i < $length; $i++) {
            $emailAddress .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $emailAddress . '@example.com';
    }
}
