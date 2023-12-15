<?php

namespace Application\RentalContext\UseCase\ViewListing;

class ViewListingResponse
{
    public function __construct(
        public readonly string $status,
        public readonly string $message,
        public readonly  mixed $data = []
    ) {
    }
}
