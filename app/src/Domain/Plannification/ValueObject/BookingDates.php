<?php

namespace Domain\Plannification\ValueObject;

use DateTimeImmutable;
use Domain\Plannification\Exceptions\DateRelatedException;
use Domain\Plannification\Factory\ExceptionFactory;

class BookingDates
{
    /**
     * Constructor for BookingDates value object.
     *
     * @param DateTimeImmutable $startDate The start date of the booking.
     * @param DateTimeImmutable $endDate The end date of the booking.
     */
    public function __construct(
        public readonly DateTimeImmutable $startDate,
        public readonly DateTimeImmutable $endDate
    ) {
    }

    /**
     * Factory method to create a BookingDates value object.
     *
     * @param DateTimeImmutable $startDate The start date of the booking.
     * @param DateTimeImmutable $endDate The end date of the booking.
     * @throws DateRelatedException if the end date is before the start date.
     * @return self A new instance of BookingDates.
     */
    public static function of(DateTimeImmutable $startDate, DateTimeImmutable $endDate): self
    {
        if ($startDate >= $endDate) {
            throw ExceptionFactory::createDateRelatedException("End date must be after the start date.");
        }

        return new self($startDate, $endDate);
    }
}
