<?php

namespace Domain\RentalContext\Exceptions;

use Exception;

class InvalidListingIdException extends Exception
{
    public function __construct(
        string $message = 'Something wrong happened',
        int $code = 0,
        Exception $previous = null
    ) {
        parent::__construct(
            $message,
            $code,
            $previous
        );
    }
}
