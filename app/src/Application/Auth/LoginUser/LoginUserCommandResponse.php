<?

namespace Application\Auth\LoginUser;

class LoginUserCommandResponse
{
    public function __construct(
        public readonly string $status,
        public readonly string $message,
        public readonly string $userId = null,
        public readonly string $userEmail = null
    ) {
    }
}
