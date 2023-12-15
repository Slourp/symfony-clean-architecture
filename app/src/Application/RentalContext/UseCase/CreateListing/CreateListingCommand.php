<?

namespace Application\RentalContext\UseCase\CreateListing;

class  CreateListingCommand
{
    public  function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $price,
        public readonly string $location,
    ) {
    }
}
