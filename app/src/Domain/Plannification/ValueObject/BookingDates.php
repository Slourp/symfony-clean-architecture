<?php

namespace Domain\Plannification\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;
use Domain\Plannification\Factory\ExceptionFactory;

class BookingDates
{
    public function __construct(
        public readonly DateTimeImmutable $startDate,
        public readonly DateTimeImmutable $endDate
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public static function of(DateTimeImmutable $startDate, DateTimeImmutable $endDate): self
    {
        if ($startDate >= $endDate) ExceptionFactory::createInvalidDateRangeException();

        return new self($startDate, $endDate);
    }
}
