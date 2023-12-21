<?php

namespace Domain\Plannification\Exceptions;

use Exception;

class BookingStateException extends Exception
{
    public function __construct(
        string $message = 'Booking state error',
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
