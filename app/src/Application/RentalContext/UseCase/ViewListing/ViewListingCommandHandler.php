<?php

namespace Application\RentalContext\UseCase\ViewListing;


use Domain\RentalContext\Gateway\ListingRepositoryI;

class ViewListingCommandHandler implements ViewListingInput
{
    public  ?\Exception $error  = null;

    private const STATUS_LISTING_ALREADY_EXISTS = 'LISTING_ALREADY_EXISTS';
    private const STATUS_LISTING_VIEWED = 'LISTING_VIEWED';
    private const STATUS_UNABLE_TO_VIEW_LISTING = 'UNABLE_TO_VIEW_LISTING';

    public function __construct(protected ListingRepositoryI $repository)
    {
    }
    public function viewListing(ViewListingCommand $command): ViewListingResponse
    {
        try {
            $listing = $this->repository->findById($command->id);

            if ($listing === null) return new ViewListingResponse(self::STATUS_LISTING_ALREADY_EXISTS, 'No listing with this id found', null);

            return new ViewListingResponse(self::STATUS_LISTING_VIEWED, 'Listing is successfully viewed', $listing);
        } catch (\Exception $e) {
            $this->error = $e;

            return new ViewListingResponse(self::STATUS_UNABLE_TO_VIEW_LISTING, $e->getMessage(), null);
        }
    }
}
