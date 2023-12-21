<?php

namespace Domain\Plannification\Factory;

use Domain\Plannification\Exceptions\InvalidOwnerException;
use Domain\Plannification\Exceptions\InvalidTenantException;
use Domain\Plannification\Exceptions\InvalidCapacityException;
use Domain\Plannification\Exceptions\CapacityExceededException;
use Domain\Plannification\Exceptions\DateNotAvailableException;
use Domain\Plannification\Exceptions\InvalidDateRangeException;
use Domain\Plannification\Exceptions\OverlappingBookingException;
use Domain\Plannification\Exceptions\BookingCancellationException;
use Domain\Plannification\Exceptions\BookingModificationException;
use Domain\Plannification\Exceptions\InvalidBookingStateException;
use Domain\Plannification\Exceptions\UnauthorizedModificationException;

class ExceptionFactory
{
    public static function createDateNotAvailableException(): DateNotAvailableException
    {
        throw new DateNotAvailableException();
    }

    public static function createBookingModificationException(): BookingModificationException
    {
        throw new BookingModificationException();
    }

    public static function createCapacityExceededException(): CapacityExceededException
    {
        throw new CapacityExceededException();
    }

    public static function createInvalidBookingStateException(): InvalidBookingStateException
    {
        throw new InvalidBookingStateException();
    }

    public static function createOverlappingBookingException(): OverlappingBookingException
    {
        throw new OverlappingBookingException();
    }

    public static function createUnauthorizedModificationException(): UnauthorizedModificationException
    {
        throw new UnauthorizedModificationException();
    }

    public static function createInvalidTenantException(): InvalidTenantException
    {
        throw new InvalidTenantException();
    }

    public static function createInvalidOwnerException(): InvalidOwnerException
    {
        throw new InvalidOwnerException();
    }

    public static function createBookingCancellationException(): BookingCancellationException
    {
        throw new BookingCancellationException();
    }

    public static function createInvalidCapacityException(): InvalidCapacityException
    {
        throw new InvalidCapacityException();
    }

    public static function createInvalidDateRangeException(): InvalidDateRangeException
    {
        throw new InvalidDateRangeException();
    }
}
