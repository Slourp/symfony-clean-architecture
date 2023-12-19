<?

namespace Domain\HousingManagement\ValueObject;

class Description
{
    public function __construct(
        public readonly string $value
    ) {
    }
}
