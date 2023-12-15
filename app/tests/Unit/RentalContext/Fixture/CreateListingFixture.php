<?php

namespace Tests\Unit\RentalContext\Fixture;

use Application\RentalContext\UseCase\CreateListing\CreateListingCommand;
use Application\RentalContext\UseCase\CreateListing\CreateListingCommandHandler;
use Tests\Unit\RentalContext\Repository\InMemoryListingRepository;

class CreateListingFixture
{

    private ?\Throwable $error = null;

    public function __construct(
        private InMemoryListingRepository $repository,
        private CreateListingCommandHandler $createListing,
    ) {
    }

    public function whenListingIsCreated(CreateListingCommand $command): void
    {
        try {
            $this->createListing->createListing($command);
        } catch (\Throwable $th) {
            $this->error = $th;
        }
    }

    public function thenErrorShouldBe(string $expectedError): void
    {

        expect(get_class($this->error))->toBe($expectedError);
    }

    public function thenListingShouldBeCreatedWithDetails(string $title, string $description): void
    {
        $listing = $this->repository->findByTitleAndDescription($title, $description);
        expect($listing->getTitle()->value)->toBe($title, "The created listing's title does not match the expected value");
        expect($listing->getDescription()->value)->toBe($description, "The created listing's description does not match the expected value");
    }
}
