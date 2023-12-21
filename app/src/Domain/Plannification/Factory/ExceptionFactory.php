<?php

namespace Domain\Plannification\Factory;

use Domain\Plannification\Exceptions\DateRelatedException;
use Domain\Plannification\Exceptions\BookingStateException;
use Domain\Plannification\Exceptions\ResourceValidationException;

class ExceptionFactory
{
    public static function createDateRelatedException(string $message = 'Date-related error'): DateRelatedException
    {
        throw new DateRelatedException($message);
    }

    public static function createBookingStateException(string $message = 'Booking state error'): BookingStateException
    {
        throw new BookingStateException($message);
    }

    public static function createResourceValidationException(string $message = 'Resource validation error'): ResourceValidationException
    {
        throw new ResourceValidationException($message);
    }
}
