<?

namespace Application\Auth\RegisterUser;

class RegisterUserCommand
{
    public  function __construct(
        public readonly ?string $username = null,
        public readonly ?string $email = null,
        public readonly ?string $password = null
    ) {
    }
}
