<?

namespace Domain\AuthContext\Entity;

use Domain\AuthContext\ValueObject\Email;
use Domain\AuthContext\ValueObject\Password;
use Domain\AuthContext\ValueObject\UserName;

class User
{
    public function __construct(
        private UserName        $userName,
        private Email           $email,
        private ?Password $password = null,
        public readonly ?string $id = null,

    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }
    public function getUserName(): UserName
    {
        return $this->userName;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function updatePassword(Password $newPassword): void
    {
        $this->password = Password::of($newPassword);
    }
}
