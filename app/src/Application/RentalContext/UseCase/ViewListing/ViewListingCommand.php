<?

namespace Application\RentalContext\UseCase\ViewListing;

class  ViewListingCommand
{
    public  function __construct(
        public readonly string $id,

    ) {
    }
}
