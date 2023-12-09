<?

namespace Domain\AuthContext\ValueObject;

use Domain\AuthContext\Exceptions\InvalidPasswordException;

class Password
{
    private function __construct(public readonly string $value)
    {
    }

    public static function of(string $value): self
    {
        if (strlen($value) > 20) throw new InvalidPasswordException(
            "Password cannot exceed 20 characters."
        );

        if (!preg_match('/^(?=.*[A-Z])(?=.*[\W])(?=.*[a-z]).{8,}$/', $value))
            throw new InvalidPasswordException(
                "Password must contain at least 8 characters, including uppercase, lowercase letters and special characters."
            );
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
