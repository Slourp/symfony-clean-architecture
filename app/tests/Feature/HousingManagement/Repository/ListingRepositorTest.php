<?php

namespace Tests\Feature\HousingManagement\Repository;

use Faker\Factory as Faker;
use Symfony\Component\Console\Input\ArrayInput;
use Domain\HousingManagement\Builder\ListingBuilder;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Infrastructure\Symfony\Repository\ListingRepository;
use Domain\HousingManagement\Entity\Listing as DomainListing;

uses(KernelTestCase::class)->in('Command');

beforeEach(function () {
    self::bootKernel();

    // Reset the database
    $this->runConsoleCommand('doctrine:database:drop --force --env=test');
    $this->runConsoleCommand('doctrine:database:create --env=test');
    $this->runConsoleCommand('doctrine:migrations:migrate --no-interaction --env=test');

    // Initialize the repository and Faker
    $this->repository = $this->getContainer()->get(ListingRepository::class);
    $this->faker = Faker::create();
    $this->builder = new ListingBuilder();
});

// Helper function to run console commands
function runConsoleCommand(string $command): int
{
    $application = new Application($this->kernel);
    $input = new ArrayInput(['command' => $command]);
    $application->setAutoExit(false);
    return $application->run($input);
}


// Test pour la méthode save
it('saves a new domain listing', function () {

    $domainListing = $this->builder
        ->withId($this->faker->uuid())
        ->withOwnerId($this->faker->uuid())
        ->withTenantId($this->faker->uuid())
        ->withListingId($this->faker->uuid())
        ->withDates(
            $this->faker->date('Y-m-d'),
            $this->faker->date('Y-m-d', '+1 week')
        )
        ->actualDate($this->faker->date('Y-m-d'))
        ->withNumberOfGuests($this->faker->numberBetween(1, 5))
        ->withMaxCapacity($this->faker->numberBetween(1, 10))
        ->thresholdDays($this->faker->numberBetween(1, 30))
        ->withExistingBookings([]) // Remplacez ceci par un tableau de réservations existantes si nécessaire
        ->build();

    $result = $this->repository->save($domainListing);
    expect($result)->toBeTrue();
    // Vérifiez si les données sont correctement enregistrées dans la base de données
});

// Test pour la méthode findByTitleAndDescription
it('finds a listing by title and description', function () {
    $title = $this->faker->sentence;
    $description = $this->faker->text;
    $domainListing = (new ListingBuilder())
        ->withTitle($title)
        ->withDescription($description)
        // Ici, incluez toutes les autres méthodes du builder
        ->build();
    $this->repository->save($domainListing);

    $foundListing = $this->repository->findByTitleAndDescription($title, $description);
    expect($foundListing)->toBeInstanceOf(DomainListing::class);
    // Vérifiez si les données correspondent
});

// Test pour la méthode findById
it('finds a listing by id', function () {
    $id = $this->faker->uuid;
    $domainListing = (new ListingBuilder())
        ->withId($id)
        // Ici, incluez toutes les autres méthodes du builder
        ->build();
    $this->repository->save($domainListing);

    $foundListing = $this->repository->findById($id);
    expect($foundListing)->toBeInstanceOf(DomainListing::class);
    // Vérifiez si les données correspondent
});
