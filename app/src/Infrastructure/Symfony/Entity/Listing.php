<?php

namespace Infrastructure\Symfony\Entity;

use Doctrine\ORM\Mapping as ORM;
use Infrastructure\Symfony\Repository\ListingRepository;

#[ORM\Entity(repositoryClass: ListingRepository::class)]
class Listing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 155)]
    private ?string $title = null;

    #[ORM\Column(length: 500)]
    private ?string $description = null;

    #[ORM\Column(type: 'float')]
    private ?float $price = null;

    #[ORM\Column(length: 255)]
    private ?string $location = null;

    #[ORM\Column(type: 'integer')]
    private ?int $capacity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): static
    {
        $this->capacity = $capacity;

        return $this;
    }



    /**
     * @return array<string, int|string|float|null>
     */    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'price' => $this->getPrice(),
            'location' => $this->getLocation(),
            'capacity' => $this->getCapacity(),
        ];
    }

    /**
     * Create a new Listing from an array
     *
     * @param  array<string, mixed> $data
     * @return Listing
     */
    public static function create(array $data): Listing
    {
        $newListing = new Listing();
        $newListing->setTitle($data['title']);
        $newListing->setDescription($data['description']);
        $newListing->setPrice($data['price']);
        $newListing->setLocation($data['location']);
        $newListing->setCapacity($data['capacity']);

        return $newListing;
    }
}
