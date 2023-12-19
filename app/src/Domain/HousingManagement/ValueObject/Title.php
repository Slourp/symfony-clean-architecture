<?php

namespace Domain\HousingManagement\ValueObject;

use Domain\HousingManagement\Exceptions\TitleInvalidArgumentException;

class Title
{
    public function __construct(
        public readonly string $value
    ) {
    }

    public static function of(?string $title): self
    {

        if (empty($title)) {
            throw new TitleInvalidArgumentException('Title can not be empty');
        }

        if (strlen($title) < 5) {
            throw new TitleInvalidArgumentException('Title must be at least 5 characters long.');
        }

        return new self($title);
    }
}
