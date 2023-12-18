<?

namespace Domain\RentalContext\ValueObject;

use Ramsey\Uuid\Uuid;

class UserId
{
    public readonly ?string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function of(string $value): self
    {
        if (!Uuid::isValid($value)) {
            throw new \InvalidArgumentException(
                sprintf('Provided value is not a valid UUID: %s', $value)
            );
        }

        return new self($value);
    }
}
