<?

namespace Application\Auth\LoginUser;

use Domain\AuthContext\Contract\UserSessionContract;
use Domain\AuthContext\Gateway\UserRepositoryWriteI;
use Domain\AuthContext\ValueObject\Email;
use Domain\AuthContext\ValueObject\Password;

class LoginUserCommandHandler implements LoginUserInput
{
    public function __construct(
        protected UserRepositoryWriteI $userRepositoryRead,
        protected UserSessionContract $userSession
    ) {
    }

    public function loginUser(LoginUserCommand $command): LoginUserCommandResponse
    {
        try {
            $user = $this->userRepositoryRead->findByEmail((Email::of($command->email))->value);
        } catch (\Exception $e) {
            return new LoginUserCommandResponse('LOGIN_FAILED', $e->getMessage());
        }

        if ($user === null || $user->getPassword()->value !== (Password::of($command->password))->value) {
            return new LoginUserCommandResponse('LOGIN_FAILED', 'Invalid email or password');
        }

        try {
            $this->userSession->create($user);
        } catch (\Exception $e) {
            return new LoginUserCommandResponse('LOGIN_FAILED', $e->getMessage());
        }

        return new LoginUserCommandResponse('LOGIN_SUCCESS', 'User is successfully logged in', $user->getId(), $user->getEmail());
    }
}
