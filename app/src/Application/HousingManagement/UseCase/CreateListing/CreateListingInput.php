<?php

namespace Application\HousingManagement\UseCase\CreateListing;

interface CreateListingInput
{
    public function createListing(CreateListingCommand $command): CreateListingCommandResponse;
}
