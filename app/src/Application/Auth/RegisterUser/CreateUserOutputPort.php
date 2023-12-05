<?

namespace Application\Auth\RegisterUser;

use Application\Interface\ViewModel;

interface CreateUserOutputPort
{
    public function present(RegisterUserCommandResponse $response): ViewModel;

    public function userCreated(RegisterUserCommandResponse $response): ViewModel;

    public function userAlreadyExists(RegisterUserCommandResponse $response): ViewModel;

    public function unableToCreateUser(RegisterUserCommandResponse $response): ViewModel;
}
