<?php

namespace Domain\RentalContext\Gateway;

use Domain\RentalContext\Entity\Listing;

interface ListingRepositoryI
{
    public function save(Listing $listing): bool;
    public function findByTitleAndDescription(string $title, string $description): ?Listing;

    public function findById(string $uuid): ?Listing;
}
