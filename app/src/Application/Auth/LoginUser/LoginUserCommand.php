<?

namespace Application\Auth\LoginUser;

class LoginUserCommand
{
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {
    }
}
