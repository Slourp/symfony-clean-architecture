<?php

use Application\RentalContext\Exceptions\TitleMissingException;
use Tests\Unit\RentalContext\Fixture\CreateListingFixture;
use Application\RentalContext\UseCase\CreateListing\CreateListingCommand;
use Application\RentalContext\UseCase\CreateListing\CreateListingCommandHandler;
use Tests\Unit\RentalContext\Repository\InMemoryListingRepository;

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
                location: '123 Main St, Downtown'
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
                location: '456 Elm St, Suburb'
            );

            $this->fixture->whenListingIsCreated($command);

            // Assuming you have a specific Exception for this scenario
            $this->fixture->thenErrorShouldBe(TitleMissingException::class);
        });
    });


    describe("Scenario: Incorrect Listing Creation - Invalid price", function () {
        it('throws an error when price is invalid', function () {
            // TODO: Implémenter le test pour un prix invalide
        })->skip('Pending implementation');
    });

    // ... Ajouter d'autres scénarios pour d'autres conditions invalides comme une localisation invalide, des images manquantes, etc.
});
