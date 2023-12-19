<?php

namespace Application\HousingManagement\Exceptions;

use Exception;

class TitleInvalidArgumentException extends Exception
{
    public function __construct(
        protected $message = 'Title is required and cannot be empty.',
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
