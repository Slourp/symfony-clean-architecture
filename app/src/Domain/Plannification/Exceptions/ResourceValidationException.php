<?php

namespace Domain\Plannification\Exceptions;

use Exception;

class ResourceValidationException extends Exception
{
    public function __construct(
        string $message = 'Resource validation error',
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
