<?php

namespace Domain\Plannification\ValueObject;

class Capacity
{
    public  function __construct(public readonly int $value)
    {
    }

    public static function of(int $value): self
    {
        if ($value < 1 || $value > 15) {
            throw new \InvalidArgumentException('Capacity must be between 1 and 15.');
        }
        return new self($value);
    }
}
