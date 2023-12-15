<?

namespace Application\RentalContext\UseCase\CreateListing;


use Domain\RentalContext\Entity\Listing;
use Domain\RentalContext\ValueObject\Description;
use Domain\RentalContext\ValueObject\Price;
use Domain\RentalContext\ValueObject\Title;
use Tests\Unit\RentalContext\Repository\InMemoryListingRepository;

class CreateListingCommandHandler implements CreateListingInput
{
    public function __construct(private InMemoryListingRepository $repository)
    {
    }

    public function createListing(CreateListingCommand $command): void
    {
        $listing = new Listing(
            title: new Title($command->title),
            description: new Description($command->description),
            price: new Price($command->price),
            location: $command->location
        );

        $this->repository->save($listing);
    }
}
