<?php

namespace Tests\Unit\RentalContext\Repository;

use Domain\RentalContext\Entity\Listing;
use Domain\RentalContext\Gateway\ListingRepositoryI;
use Ramsey\Uuid\Uuid;

class InMemoryListingRepository implements ListingRepositoryI
{
    private array $listings = [];

    public function save(Listing $listing): bool
    {
        $listingArray = $listing->toArray();

        if ($listingArray['id'] === null) {
            $listingArray['id'] = Uuid::uuid4()->toString();
        }

        $this->listings[$listingArray['id']] = $listingArray;
        return true;
    }

    public function findByTitleAndDescription(string $title, string $description): ?Listing
    {
        foreach ($this->listings as $listing) {
            if ($listing['title'] === $title && $listing['description'] === $description) {
                return Listing::fromArray($listing);
            }
        }

        return null;
    }

    public function findById(string $uuid): ?Listing
    {
        return $this->listings[$uuid] ?? Listing::fromArray($this->listings[$uuid]);
    }
}
