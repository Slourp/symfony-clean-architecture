<?

namespace Domain\HousingManagement\Builder;

use Domain\HousingManagement\Entity\Listing;
use Domain\HousingManagement\ValueObject\Price;
use Domain\HousingManagement\ValueObject\Title;
use Domain\HousingManagement\ValueObject\Capacity;
use Domain\HousingManagement\ValueObject\Location;
use Domain\HousingManagement\ValueObject\Description;
use Domain\HousingManagement\ValueObject\ListingId;

class ListingBuilder
{
    private string $title;
    private string $description;
    private string $price;
    private string $location;
    private string $capacity;
    private ?string $id = null;

    public function withId(?string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public static function create(): self
    {
        return new self();
    }

    public function withTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function withDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function withPrice(string $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function withLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function withCapacity(string $capacity): self
    {
        $this->capacity = $capacity;
        return $this;
    }

    public function build(): Listing
    {
        return new Listing(
            capacity: Capacity::of((int)$this->capacity),
            price: Price::of((float)$this->price),
            description: Description::of($this->location),
            title: Title::of($this->title),
            location: Location::of($this->description)->value,
            id: $this->id ? ListingId::of($this->id) : null
        );
    }
}
