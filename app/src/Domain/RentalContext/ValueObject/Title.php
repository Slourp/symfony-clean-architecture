<?

namespace Domain\RentalContext\ValueObject;

class Title
{
    public function __construct(
        public readonly string $value
    ) {
    }
}
