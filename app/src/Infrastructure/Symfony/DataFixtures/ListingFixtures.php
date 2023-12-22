<?php

namespace Infrastructure\Symfony\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Domain\HousingManagement\Builder\ListingBuilder;
use Faker\Factory as Faker;
use Infrastructure\Symfony\Entity\Listing;

// class ListingFixtures extends Fixture
// {
//     public function load(ObjectManager $manager): void
//     {
//         $faker = Faker::create();

//         for ($i = 0; $i < 20; $i++) {
//             $listing = ListingBuilder::create()
//                 ->withTitle($faker->sentence(3))
//                 ->withDescription($faker->sentence(15))k
//                 ->withPrice((string) $faker->randomFloat(2, 100, 1000))
//                 ->withLocation($faker->address)
//                 ->withCapacity((string) $faker->numberBetween(1, 5))
//                 ->build()
//                 ->toArray();

//             $entityListing = Listing::create($listing);
//             $manager->persist($entityListing);
//         }

//         $manager->flush();
//     }
// }
