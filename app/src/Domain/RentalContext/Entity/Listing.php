<?php

namespace Domain\RentalContext\Entity;

use Application\RentalContext\Exceptions\TitleInvalidArgumentException;
use Application\RentalContext\Exceptions\TitleMissingException;
use Domain\RentalContext\ValueObject\Description;
use Domain\RentalContext\ValueObject\Price;
use Domain\RentalContext\ValueObject\Title;
use InvalidArgumentException;

class Listing
{



    public function __construct(
        private Title $title,
        private Description $description,
        private Price $price,
        private string $location,
        public  readonly ?string  $id = null
    ) {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setPrice($price);
        $this->setLocation($location);
    }

    public function setTitle(Title $title): void
    {
        if (empty($title->value)) {
            throw new TitleInvalidArgumentException('Title can not be empty');
        }
        if (strlen($title->value) < 5) {
            throw new TitleInvalidArgumentException('Title must be at least 5 characters long.');
        }

        $this->title = $title;
    }

    public function setDescription(Description $description): void
    {
        if (strlen($description->value) < 20) {
            throw new InvalidArgumentException('Description must be at least 20 characters long.');
        }

        $this->description = $description;
    }

    public function setPrice(Price $price): void
    {
        if ($price->value < 0) {
            throw new InvalidArgumentException('Price should be positive.');
        }

        $this->price = $price;
    }
    public function setLocation(string $location): void
    {
        if (empty($location)) {
            throw new InvalidArgumentException('Location is required.');
        }

        $this->location = $location;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getDescription(): Description
    {
        return $this->description;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
    public function getLocation(): string
    {
        return $this->location;
    }
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title->value,
            'description' => $this->description->value,
            'price' => $this->price->value,
            'location' => $this->location,
        ];
    }
    public static function fromArray(array $data): self
    {
        return new self(
            title: new Title($data['title']),
            description: new Description($data['description']),
            price: new Price($data['price']),
            location: $data['location'],
            id: isset($data['id']) && !is_null($data['id']) ? $data['id'] : null,
        );
    }
}
