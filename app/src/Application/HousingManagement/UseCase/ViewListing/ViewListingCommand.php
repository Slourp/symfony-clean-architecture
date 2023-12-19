<?

namespace Application\HousingManagement\UseCase\ViewListing;

class  ViewListingCommand
{
    public  function __construct(
        public readonly string $id,

    ) {
    }
}
