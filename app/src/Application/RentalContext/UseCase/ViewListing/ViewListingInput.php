<?php

namespace Application\RentalContext\UseCase\ViewListing;

use Application\RentalContext\UseCase\ViewListing\ViewListingCommand;

interface ViewListingInput
{
    public function viewListing(ViewListingCommand $command): ViewListingResponse;
}
