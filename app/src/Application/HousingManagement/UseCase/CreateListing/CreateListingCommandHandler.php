<?

namespace Application\HousingManagement\UseCase\CreateListing;

use Domain\HousingManagement\Entity\Listing;
use Domain\HousingManagement\ValueObject\Capacity;
use Domain\HousingManagement\ValueObject\Description;
use Domain\HousingManagement\ValueObject\Price;
use Domain\HousingManagement\ValueObject\Title;
use Tests\Unit\HousingManagement\Repository\InMemoryListingRepository;

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
                location: $command->location,
                capacity: new Capacity($command->capacity)

            );

            $this->repository->save($listing);

            return new CreateListingCommandResponse(self::STATUS_LISTING_CREATED, 'Listing successfully created', $listing);
        } catch (\Exception $e) {
            $this->error = $e;
            return new CreateListingCommandResponse(self::STATUS_UNABLE_TO_CREATE_LISTING, $e->getMessage(), null);
        }
    }
}
