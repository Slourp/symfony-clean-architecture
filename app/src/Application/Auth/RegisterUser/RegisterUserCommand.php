<?

namespace Application\Auth\RegisterUser;

class RegisterUserCommand
{
    public  function __construct(
        public readonly string $username,
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $id = null

    ) {
    }
}
