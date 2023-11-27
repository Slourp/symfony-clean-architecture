<?

namespace Domain\AuthContext\ValueObject;

use Domain\AuthContext\Exceptions\InvalidUserNameException;

class UserName
{
    private function __construct(
        public readonly string $value
    ) {
    }

    public static function of(?string $value): self
    {
        if (strlen($value) < 4) throw new InvalidUserNameException(
            "User name cannot be less than 4 characters."
        );

        return new self($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
