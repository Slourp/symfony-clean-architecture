<?

namespace Domain\RentalContext\ValueObject;

class NumberOfGuests
{
    private function __construct(
        public readonly int $value
    ) {
    }

    public static function of(int $value): self
    {
        if ($value < 1 || $value > 15) throw new \InvalidArgumentException('Number of guests must be between 1 and 15.');

        return new self($value);
    }
}
