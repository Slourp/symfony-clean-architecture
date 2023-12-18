<?

namespace Application\RentalContext\UseCase\CreateListing;

use Domain\RentalContext\Entity\Listing;
use Domain\RentalContext\ValueObject\Description;
use Domain\RentalContext\ValueObject\Price;
use Domain\RentalContext\ValueObject\Title;
use Tests\Unit\RentalContext\Repository\InMemoryListingRepository;

class CreateListingCommandHandler implements CreateListingInput
{
    public  ?\Exception $error  = null;

    private const STATUS_LISTING_CREATED = 'LISTING_CREATED';
    private const STATUS_UNABLE_TO_CREATE_LISTING = 'UNABLE_TO_CREATE_LISTING';

    public function __construct(private InMemoryListingRepository $repository)
    {
    }

    public function createListing(CreateListingCommand $command): CreateListingCommandResponse
    {
        try {
            $listing = new Listing(
                title: new Title($command->title),
                description: new Description($command->description),
                price: new Price((float) $command->price),
                location: $command->location
            );

            $this->repository->save($listing);

            return new CreateListingCommandResponse(self::STATUS_LISTING_CREATED, 'Listing successfully created', $listing);
        } catch (\Exception $e) {
            $this->error = $e;
            return new CreateListingCommandResponse(self::STATUS_UNABLE_TO_CREATE_LISTING, $e->getMessage(), null);
        }
    }
}
