<?php

namespace Tests\Unit\HousingManagement\Repository;

use Domain\HousingManagement\Entity\Listing;
use Domain\HousingManagement\Gateway\ListingRepositoryI;
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
        if (!isset($this->listings[$uuid])) return null;
        return  Listing::fromArray($this->listings[$uuid]);
    }
}
