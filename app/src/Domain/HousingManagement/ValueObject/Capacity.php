<?

namespace Domain\HousingManagement\ValueObject;

use InvalidArgumentException;

class Capacity
{
    private int $value;

    public function __construct(int $value)
    {
        $this->setValue($value);
    }

    private function setValue(int $value): void
    {
        self::validate($value);
        $this->value = $value;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public static function of(int $value): self
    {
        self::validate($value);
        return new self($value);
    }

    private static function validate(int $value): void
    {
        if ($value < 1 || $value > 15) {
            throw new InvalidArgumentException('Capacity must be between 1 and 15.');
        }
    }
}
