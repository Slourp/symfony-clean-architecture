<?php

namespace Domain\RentalContext\ValueObject;

use Ramsey\Uuid\Uuid;

class ListingId
{
    private function __construct(public readonly ?string $value = null)
    {
    }
    public static function of(string $value): self
    {
        if (is_null($value)) return new static($value);

        if (!Uuid::isValid($value))
            throw new \InvalidArgumentException(
                sprintf('Provided value is not a valid UUID: %s', $value)
            );
        return new static($value);
    }
}
