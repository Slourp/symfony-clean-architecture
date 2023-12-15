<?

namespace Domain\RentalContext\ValueObject;

class Location
{
    public function __construct(
        public readonly string $value
    ) {
    }
}
