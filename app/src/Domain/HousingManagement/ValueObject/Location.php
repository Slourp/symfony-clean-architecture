<?

namespace Domain\HousingManagement\ValueObject;

class Location
{
    public function __construct(
        public readonly string $value
    ) {
    }
}
