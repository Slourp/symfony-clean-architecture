<?php

namespace Domain\RentalContext\ValueObject;

use Domain\RentalContext\Exceptions\InvalidPriceException;


class Price
{
    public function __construct(
        public readonly float $value
    ) {
    }

    public static function of(?float $value): self
    {
        if ($value === null || $value <= 0) {
            throw new InvalidPriceException();
        }

        return new self($value);
    }
}
