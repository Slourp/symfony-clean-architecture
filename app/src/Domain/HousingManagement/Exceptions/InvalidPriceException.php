<?php

namespace Domain\HousingManagement\Exceptions;

use Exception;

class InvalidPriceException extends Exception
{
    public function __construct(
        string $message = 'Price format is incorrect',
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
