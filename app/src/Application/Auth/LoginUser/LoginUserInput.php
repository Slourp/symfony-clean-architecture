<?

namespace Application\Auth\LoginUser;

interface LoginUserInput
{
    public function loginUser(LoginUserCommand $command): LoginUserCommandResponse;
}
