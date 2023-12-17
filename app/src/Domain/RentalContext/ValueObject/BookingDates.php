<?php

namespace Domain\RentalContext\ValueObject;

use DateTimeImmutable;
use InvalidArgumentException;

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
        if ($startDate >= $endDate) {
            throw new InvalidArgumentException('Start date cannot be later than end date.');
        }

        return new self($startDate, $endDate);
    }
}
