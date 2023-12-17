<?php

namespace Application\RentalContext\UseCase\CreateListing;

interface CreateListingInput
{
    public function createListing(CreateListingCommand $command): CreateListingCommandResponse;
}
