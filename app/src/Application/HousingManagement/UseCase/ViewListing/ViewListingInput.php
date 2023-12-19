<?php

namespace Application\HousingManagement\UseCase\ViewListing;

use Application\HousingManagement\UseCase\ViewListing\ViewListingCommand;

interface ViewListingInput
{
    public function viewListing(ViewListingCommand $command): ViewListingResponse;
}
