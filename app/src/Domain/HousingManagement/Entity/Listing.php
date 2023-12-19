<?php

namespace Domain\HousingManagement\Entity;

use Domain\HousingManagement\ValueObject\Capacity;
use Domain\HousingManagement\ValueObject\Description;
use Domain\HousingManagement\ValueObject\ListingId;
use Domain\HousingManagement\ValueObject\Price;
use Domain\HousingManagement\ValueObject\Title;
use InvalidArgumentException;

class Listing
{
    public function __construct(
        private Capacity $capacity,
        private Description $description,
        private Price $price,
        private string $location,
        private Title $title,
        public  readonly ?ListingId  $id = null
    ) {
        $this->setTitle($title);
        $this->setDescription($description);
        $this->setPrice($price);
        $this->setLocation($location);
        $this->setCapacity($capacity);
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

    public function setCapacity(Capacity $capacity): void
    {
        $this->capacity = $capacity;
    }

    public function getCapacity(): Capacity
    {
        return $this->capacity;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id ? $this->id->value : null,
            'title' => $this->title->value,
            'description' => $this->description->value,
            'price' => $this->price->value,
            'location' => $this->location,
            'capacity' => $this->capacity->getValue(),
        ];
    }

    /**
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            title: Title::of($data['title']),
            description: new Description($data['description']),
            price: Price::of($data['price']),
            location: $data['location'],
            capacity: new Capacity($data['capacity']),
            id: isset($data['id']) && !empty($data['id'])
                ? ListingId::of($data['id'])
                : null
        );
    }
}
