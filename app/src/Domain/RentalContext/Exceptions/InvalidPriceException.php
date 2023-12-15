<?php

namespace Domain\RentalContext\Exceptions;

use Exception;

class InvalidPriceException extends Exception
{
    public function __construct(
        protected $message = 'Price format is incorrect',
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
