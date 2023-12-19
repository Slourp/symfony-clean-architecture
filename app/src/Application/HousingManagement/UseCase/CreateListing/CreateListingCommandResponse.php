<?

namespace Application\HousingManagement\UseCase\CreateListing;


use Domain\HousingManagement\Entity\Listing;

class CreateListingCommandResponse
{
    public function __construct(
        public readonly string $status,
        public readonly string $message,
        public readonly ?Listing $listing = null
    ) {
    }
}
