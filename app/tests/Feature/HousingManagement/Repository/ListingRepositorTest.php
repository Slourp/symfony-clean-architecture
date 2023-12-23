<?php

namespace Tests\Feature\HousingManagement\Repository;

use Infrastructure\Symfony\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Faker\Factory as Faker;
use Domain\HousingManagement\Builder\ListingBuilder;
use Domain\HousingManagement\Entity\Listing as EntityListing;
use Infrastructure\Symfony\Entity\Listing;
use Symfony\Component\Uid\UuidV4;

uses(KernelTestCase::class);

beforeEach(function (): void {

    $kernel = KernelTestCase::bootKernel();
    $this->entityManager = $kernel->getContainer()->get('doctrine')->getManager();
    $this->listingRepository = $this->entityManager->getRepository(Listing::class);
    $this->faker = Faker::create();
});

afterEach(function (): void {
    $this->entityManager->close();
    $this->entityManager = null;
});

it('saves a listing', function () {
    $domainListing = ListingBuilder::create()
        ->withTitle($this->faker->sentence(10))
        ->withDescription($this->faker->sentence(20))
        ->withPrice($this->faker->randomFloat(2, 100, 1000))
        ->withLocation($this->faker->address())
        ->withCapacity($this->faker->randomDigitNotNull())
        ->build();

    $result = $this->listingRepository->save($domainListing);
    /** @var EntityListing */
    $listingInDatabase = $this->listingRepository->findByTitleAndDescription($domainListing->getTitle()->value, $domainListing->getDescription()->value);

    expect($result)->toBeTrue();
    expect($listingInDatabase->getDescription()->value)->toEqual($domainListing->getDescription()->value);
});

it('finds a listing by title and description', function () {

    $domainListing = ListingBuilder::create()
        ->withTitle($this->faker->sentence(10))
        ->withDescription($this->faker->sentence(20))
        ->withPrice($this->faker->randomFloat(2, 100, 1000))
        ->withLocation($this->faker->address())
        ->withCapacity($this->faker->randomDigitNotNull())
        ->build();

    $this->listingRepository->save($domainListing);

    $foundListing = $this->listingRepository->findByTitleAndDescription(
        $domainListing->getTitle()->value,
        $domainListing->getDescription()->value
    );
    expect($foundListing)->not()->toBeNull();
    expect($foundListing->getTitle()->value)->toBe($domainListing->getTitle()->value);
    expect($foundListing->getDescription()->value)->toBe($domainListing->getDescription()->value);
});

it('finds a listing by id', function () {

    $domainListing = ListingBuilder::create()
        ->withTitle($this->faker->sentence(10))
        ->withDescription($this->faker->sentence(20))
        ->withPrice($this->faker->randomFloat(2, 100, 1000))
        ->withLocation($this->faker->address())
        ->withCapacity($this->faker->randomDigitNotNull())
        ->withId("018c939a-dab8-75ad-b545-2d90ec3c93cc")
        ->build();
    $this->listingRepository->save($domainListing);

    /**
     * @var EntityListing 
     */
    $foundListing = $this->listingRepository->findById($domainListing->id->value);
    expect($foundListing->id->value)->toBe($domainListing->id->value);
});
