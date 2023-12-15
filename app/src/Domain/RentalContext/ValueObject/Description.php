<?

namespace Domain\RentalContext\ValueObject;

class Description
{
    public function __construct(
        public readonly string $value
    ) {
    }
}
