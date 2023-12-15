<?php

namespace Domain\RentalContext\Exceptions;

use Exception;

class InvalidListingIdException extends Exception
{
    public function __construct(
        protected $message = 'Something wrong happened',
        protected $code = 0,
        Exception $previous = null
    ) {
        parent::__construct(
            $this->message,
            $code,
            $previous
        );
    }
}
