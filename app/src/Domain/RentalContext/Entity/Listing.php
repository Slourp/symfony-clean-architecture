<?php

namespace Domain\RentalContext\Entity;

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
        $this->title = $title::of($title->value);
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
        $this->price = $price::of($price->value);
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
            title: Title::of($data['title']),
            description: new Description($data['description']),
            price: Price::of($data['price']),
            location: $data['location'],
            id: isset($data['id']) && !is_null($data['id']) ? $data['id'] : null,
        );
    }
}
