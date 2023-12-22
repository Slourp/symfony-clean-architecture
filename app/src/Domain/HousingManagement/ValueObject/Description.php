<?

namespace Domain\HousingManagement\ValueObject;

class Description
{
    public function __construct(
        public readonly string $value
    ) {
    }

    public static function of(string $value): self
    {
        return new self($value);
    }
}
