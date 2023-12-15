<?php

namespace Tests\Unit\RentalContext\Fixture;

use Application\RentalContext\UseCase\ViewListing\ViewListingCommand;
use Application\RentalContext\UseCase\ViewListing\ViewListingCommandHandler;
use Application\RentalContext\UseCase\ViewListing\ViewListingResponse;
use Domain\RentalContext\Entity\Listing;
use Tests\Unit\RentalContext\Repository\InMemoryListingRepository;

class ViewListingFixture
{
    private ?\Throwable $error = null;
    private ?ViewListingResponse $response = null;


    public function __construct(
        private InMemoryListingRepository $repository,
        private ViewListingCommandHandler $viewListingCommandHandler,
    ) {
    }
    public function givenListingExists(Listing $listing): bool
    {
        return $this->repository->save($listing);
    }

    public function whenListingIsRequest(ViewListingCommand $command): void
    {
        try {
            $this->response = $this->viewListingCommandHandler->viewListing($command);
        } catch (\Throwable $th) {
            $this->error = $th;
        }
    }

    public function thenErrorShouldBe(string $expectedError): void
    {
        expect(get_class($this->error))->toBe($expectedError);
    }

    public function thenResponseShouldBe(string $response): void
    {
        expect($response)->toBe($this->response->message);
    }

    public function thenListingShouldBeViewedWithDetails(string $id): void
    {
        $listing = $this->repository->findById($id);
        expect($listing->id)->toBe($id, "The viewed listing's id does not match the expected value");
    }
}
