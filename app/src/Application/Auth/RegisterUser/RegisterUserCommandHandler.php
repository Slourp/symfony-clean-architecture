<?

namespace Application\Auth\RegisterUser;

use Domain\AuthContext\Entity\User;
use Domain\AuthContext\Gateway\UserRepositoryWriteI;
use Domain\AuthContext\ValueObject\Email;
use Domain\AuthContext\ValueObject\Password;
use Domain\AuthContext\ValueObject\UserName;

class RegisterUserCommandHandler implements RegisterUserInput
{

    public function __construct(
        protected UserRepositoryWriteI $userRepositoryWrite
    ) {
    }

    public function registerUser(RegisterUserCommand $command): RegisterUserCommandResponse
    {
        $user = new User(
            UserName::of($command->username),
            Email::of($command->email),
            Password::of($command->password)
        );

        $this->userRepositoryWrite->registerUser(user: $user);

        return new RegisterUserCommandResponse('USER_CREATED', 'User is successfully created', $user);
    }
}
