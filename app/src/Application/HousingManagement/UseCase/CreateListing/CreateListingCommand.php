<?

namespace Application\HousingManagement\UseCase\CreateListing;

class  CreateListingCommand
{
    public  function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly float $price,
        public readonly string $location,
        public readonly int $capacity,
    ) {
    }
}
