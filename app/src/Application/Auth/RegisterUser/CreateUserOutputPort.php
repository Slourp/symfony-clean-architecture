<?

namespace Application\Auth\RegisterUser;

use Application\Interface\ViewModel;

interface CreateUserOutputPort
{
    public function userCreated(RegisterUserCommandResponse $response): ViewModel;

    public function userAlreadyExists(RegisterUserCommandResponse $response): ViewModel;

    public function unableToCreateUser(RegisterUserCommandResponse $response): ViewModel;
}
