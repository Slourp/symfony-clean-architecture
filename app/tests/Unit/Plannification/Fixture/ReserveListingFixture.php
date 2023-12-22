<?php

namespace Tests\Unit\HousingManagement\Fixture;

use App\Domain\ReservationContext\UseCase\ReserveListingCommand;
use App\Domain\ReservationContext\UseCase\ReserveListingCommandHandler;
use Domain\HousingManagement\Entity\Listing;
use Tests\Unit\HousingManagement\Repository\InMemoryListingRepository;

class ReserveListingFixture
{
    private ?\Throwable $error = null;

    public function __construct(
        private InMemoryListingRepository $repository,
        private ReserveListingCommandHandler $reserveListingCommandHandler,
    ) {
    }

    public function givenListingExists(Listing $listing): bool
    {
        return $this->repository->save($listing);
    }

    public function whenListingIsReserved(ReserveListingCommand $command): void
    {
        try {
            $this->reserveListingCommandHandler->reserveListing($command);
        } catch (\Throwable $th) {
            $this->error = $th;
        }
    }

    public function thenErrorShouldBe(string $expectedError): void
    {
        expect(get_class($this->error))->toBe($expectedError);
    }

    public function thenListingShouldBeReserved(string $id): void
    {
        $reservation = $this->repository->findById($id);
        expect($reservation->id)->toBe($id, "The reserved listing's id does not match the expected value");
    }
}
