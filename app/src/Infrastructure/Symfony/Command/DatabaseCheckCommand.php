<?php

namespace Infrastructure\Symfony\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\DBAL\Connection;

#[AsCommand(
    name: 'app:database-check',
    description: 'Add a short description for your command',
)]
class DatabaseCheckCommand extends Command
{
    public function __construct(private Connection $connection)
    {
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Vérifie la connexion à la base de données.')
            ->setHelp('Cette commande permet de tester si la connexion à la base de données fonctionne correctement.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->connection->connect();
            $output->writeln('Connexion à la base de données réussie.');
        } catch (\Exception $e) {
            $output->writeln('Erreur de connexion à la base de données : ' . $e->getMessage());
            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
