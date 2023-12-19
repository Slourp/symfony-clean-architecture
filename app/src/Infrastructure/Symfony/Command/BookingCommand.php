<?php

namespace Infrastructure\Symfony\Command;

use Application\Auth\RegisterUser\RegisterUserCommand;
use Application\Auth\RegisterUser\RegisterUserCommandHandler;
use Application\HousingManagement\UseCase\CreateListing\CreateListingCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tests\Unit\AuthContext\Repository\InMemoryUserRepository;

#[AsCommand(
    name: 'BookingCommand',
    description: 'Add a short description for your command',
)]
class BookingCommand extends Command
{
    private InMemoryUserRepository $inMemoryUserRepository;
    private RegisterUserCommandHandler $registerUserCommandHandler;
    public function __construct()
    {
        parent::__construct();
        $this->inMemoryUserRepository = new InMemoryUserRepository();
        $this->registerUserCommandHandler = new RegisterUserCommandHandler($this->inMemoryUserRepository);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $command = new RegisterUserCommand(
            username: 'username',
            email: '123@test.com',
            password: "password123AAa12*"
        );

        $registerUserCommandHandlerResponse = $this->registerUserCommandHandler->registerUser($command);

        $command = new CreateListingCommand(
            title: 'Cozy Apartment',
            description: 'A nice and cozy apartment in downtown',
            price: 150.00,
            location: '123 Main St, Downtown'
        );
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
