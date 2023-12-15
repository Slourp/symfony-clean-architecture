<?php

use Symfony\Component\Uid\Uuid;
use Domain\RentalContext\Entity\Listing;
use Domain\RentalContext\ValueObject\Price;
use Domain\RentalContext\ValueObject\Title;
use Domain\RentalContext\ValueObject\Description;
use Tests\Unit\RentalContext\Fixture\ViewListingFixture;
use Tests\Unit\RentalContext\Repository\InMemoryListingRepository;
use Application\RentalContext\UseCase\ViewListing\ViewListingCommand;
use Application\RentalContext\UseCase\ViewListing\ViewListingCommandHandler;

beforeEach(function () {
    $repository = new InMemoryListingRepository();
    $viewListingCommandHandler = new ViewListingCommandHandler($repository);
    $this->fixture = new ViewListingFixture(
        $repository,
        $viewListingCommandHandler
    );
});


describe("Feature: Viewing a listing details", function () {

    describe("Scenario: Correct Listing View", function () {
        describe("Scenario: Correct Listing View", function () {
            it('can view listing correctly', function () {
                $id = Uuid::v4()->__toString();
                $command = new ViewListingCommand(id: $id);

                $listing = new Listing(
                    title: new Title('Cozy Apartment'),
                    description: new Description('A nice and cozy apartment in downtown'),
                    price: new Price(150),
                    location: '123 Main St, Downtown',
                    id: $id
                );

                $this->fixture->givenListingExists($listing);

                $this->fixture->whenListingIsRequest($command);

                $this->fixture->thenListingShouldBeViewedWithDetails($command->id);
            });
        });
    });

    describe("Scenario: Incorrect Listing View  - No listing id", function () {
        it('throws an error when listing id is not provided', function () {
            $command = new ViewListingCommand(id: 0);

            $this->fixture->whenListingIsRequest($command);

            $this->fixture->thenResponseShouldBe('No listing with this id found');
        });
    });
});
