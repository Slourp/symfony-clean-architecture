<?

namespace Application\Auth\RegisterUser;


use Application\Auth\RegisterUser\RegisterUserCommand;
use Application\Auth\RegisterUser\RegisterUserCommandResponse;

interface RegisterUserInput
{
    public function registerUser(RegisterUserCommand $registerUserCommand): RegisterUserCommandResponse;
}
