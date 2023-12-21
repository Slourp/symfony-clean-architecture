<?php

namespace Domain\Plannification\Exceptions;

use Exception;

class DateRelatedException extends Exception
{
    public function __construct(
        string $message = 'Date-related error',
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
