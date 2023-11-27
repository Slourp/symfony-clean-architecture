<?

namespace Domain\AuthContext\ValueObject;

use Domain\AuthContext\Exceptions\InvalidEmailException;

class Email
{

    private function __construct(
        public string $value
    ) {
    }

    public static function of(string $value): self
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException(
                "Email is not valid."
            );
        }

        return new self($value);
    }
    public function __toString(): string
    {
        return $this->value;
    }
}
