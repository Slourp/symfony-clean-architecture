<?php

namespace Infrastructure\Symfony\Command;

use Application\Auth\RegisterUser\CreateUserOutputPort;
use Application\Auth\RegisterUser\RegisterUserCommand as RegisterUser;
use Application\Auth\RegisterUser\RegisterUserInput;
use Infrastructure\Symfony\Adapter\View\CliViewModel;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $this->setName('create:run')
            ->setDescription('Creates a new user.')
            ->setHelp('This command allows you to create a user...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $username = $io->ask('Enter your username');
        $email = $io->ask('Enter your email');
        $password = $io->askHidden('Enter your password');

        $registerUser = new RegisterUser(
            username: $username,
            email: $email,
            password: $password
        );

        $response = $this->input->registerUser($registerUser);

        /**
         * @var CliViewModel
         */
        $viewModel = $this->outputCli->present($response);

        return $viewModel->getResponse($io);
    }
}
