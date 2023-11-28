<?

namespace Infrastructure\Symfony\Adapter\Presenters;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Infrastructure\Symfony\Adapter\View\CliViewModel;
use Application\Auth\RegisterUser\CreateUserOutputPort;
use Application\Auth\RegisterUser\RegisterUserCommandResponse;

class CreateUserCliPresenter implements CreateUserOutputPort
{
    public function present(RegisterUserCommandResponse $response): CliViewModel
    {
        return match ($response->status) {
            "USER_CREATED" => $this->userCreated($response),
            "USER_EXISTS" => $this->userAlreadyExists($response),
            "UNABLE_TO_CREATE_USER" => $this->unableToCreateUser($response),
            default => throw new \InvalidArgumentException("Invalid status"),
        };
    }

    public function userCreated(RegisterUserCommandResponse $response): CliViewModel
    {
        return new CliViewModel(function (SymfonyStyle $io) use ($response): int {
            $io->success("User {$response->user->getEmail()->value} {$response->user->getUserName()->value} successfully created.");
            return Command::SUCCESS;
        });
    }

    public function userAlreadyExists(RegisterUserCommandResponse $response): CliViewModel
    {
        return new CliViewModel(function (SymfonyStyle $io) use ($response): int {
            $io->error("User {$response->user->getEmail()->value} already exists!");
            return Command::FAILURE;
        });
    }

    public function unableToCreateUser(RegisterUserCommandResponse $response): CliViewModel
    {
        return new CliViewModel(function (SymfonyStyle $io) use ($response): int {
            $io->error("Error occurred while creating user: {$response->message}");
            return Command::FAILURE;
        });
    }
}
