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
            userName: UserName::of($command->username),
            email: Email::of($command->email),
            password: Password::of($command->password),
            id: $command?->id
        );
        $this->userRepositoryWrite->registerUser(user: $user);

        return new RegisterUserCommandResponse('USER_CREATED', 'User is successfully created', $user);
    }
}
