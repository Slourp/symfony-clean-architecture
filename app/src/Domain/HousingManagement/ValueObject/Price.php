<?php

namespace Domain\HousingManagement\ValueObject;

use Domain\HousingManagement\Exceptions\InvalidPriceException;


class Price
{
    public function __construct(
        public readonly float $value
    ) {
    }

    public static function of(float $value): self
    {
        if ($value <= 0) {
            throw new InvalidPriceException();
        }

        return new self($value);
    }
}
