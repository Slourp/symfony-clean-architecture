<?php

use Domain\HousingManagement\Exceptions\InvalidPriceException;
use Tests\Unit\HousingManagement\Fixture\CreateListingFixture;
use Domain\HousingManagement\Exceptions\TitleInvalidArgumentException;
use Tests\Unit\HousingManagement\Repository\InMemoryListingRepository;
use Application\HousingManagement\UseCase\CreateListing\CreateListingCommand;
use Application\HousingManagement\UseCase\CreateListing\CreateListingCommandHandler;

beforeEach(function () {
    $repository = new InMemoryListingRepository();
    $createListing = new CreateListingCommandHandler($repository);
    $this->fixture = new CreateListingFixture(
        repository: $repository,
        createListing: $createListing
    );
});

describe("Feature: Creating a Listing", function () {

    describe("Scenario: Successful Listing Creation", function () {
        it('can create a listing correctly', function () {
            $command = new CreateListingCommand(
                title: 'Cozy Apartment',
                description: 'A nice and cozy apartment in downtown',
                price: 150.00,
                location: '123 Main St, Downtown',
                capacity: 5

            );
            $this->fixture->whenListingIsCreated($command);

            $this->fixture->thenListingShouldBeCreatedWithDetails('Cozy Apartment', 'A nice and cozy apartment in downtown');
        });
    });

    describe("Scenario: Incorrect Listing Creation - No title", function () {
        it('throws an error when title is not provided', function () {
            $command = new CreateListingCommand(
                title: '', // Empty title
                description: 'Description of the listing',
                price: 100.00,
                location: '456 Elm St, Suburb',
                capacity: 5

            );

            $this->fixture->whenListingIsCreated($command);

            $this->fixture->thenErrorShouldBe(TitleInvalidArgumentException::class);
        });
    });

    describe("Scenario: Incorrect Listing Creation - Invalid price", function () {

        it('throws an error when price is invalid', function () {
            $command = new CreateListingCommand(
                title: 'Comfortable House',
                description: 'A luxurious, comfortable house in uptown',
                price: -100.00,
                location: '789 Cherry St, Uptown',
                capacity: 5
            );


            $this->fixture->whenListingIsCreated($command);
            $this->fixture->thenErrorShouldBe(InvalidPriceException::class);
        });
    });
});
