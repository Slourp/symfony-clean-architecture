<?

namespace Domain\RentalContext\ValueObject;

class Price
{
    public function __construct(
        public readonly float $value
    ) {
    }
}
