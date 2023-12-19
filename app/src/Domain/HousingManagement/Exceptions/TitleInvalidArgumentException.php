<?php

namespace Domain\HousingManagement\Exceptions;

use Exception;

class TitleInvalidArgumentException extends Exception
{
    public function __construct(
        string $message = 'Title is required and cannot be empty.',
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
