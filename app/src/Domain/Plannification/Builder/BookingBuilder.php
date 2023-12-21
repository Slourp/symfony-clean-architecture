<?php

namespace Domain\Plannification\Builder;


use DateTimeImmutable;
use Domain\Plannification\Entity\Booking;
use Domain\Plannification\ValueObject\OwnerId;
use Domain\Plannification\ValueObject\Capacity;
use Domain\Plannification\ValueObject\TenantId;
use Domain\Plannification\ValueObject\BookingId;
use Domain\Plannification\ValueObject\ListingId;
use Domain\Plannification\ValueObject\BookingDates;
use Domain\Plannification\ValueObject\NumberOfGuests;

class BookingBuilder
{
    private string $id;
    private string $ownerId;
    private string $tenantId;
    private string $listingId;
    private string $startDates;
    private string $actualDate;
    private string $endDates;
    private int $numberOfGuests;
    private int $maxCapacity;
    private int $updateThresholdDays;

    /**
     * @var Booking[]
     * 
     */
    private array $existingBookings = [];

    public function withId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function withListingId(string $listingId): self
    {
        $this->listingId = $listingId;
        return $this;
    }

    public function withDates(string $startDate, string $endDate): self
    {
        $this->startDates = $startDate;
        $this->endDates = $endDate;

        return $this;
    }

    public function actualDate(string $givenActualDate): self
    {
        $this->actualDate = $givenActualDate;
        return $this;
    }

    public function withNumberOfGuests(int $numberOfGuests): self
    {
        $this->numberOfGuests = $numberOfGuests;
        return $this;
    }

    public function withMaxCapacity(int $maxCapacity): self
    {
        $this->maxCapacity = $maxCapacity;
        return $this;
    }

    public function withTenantId(string $tenantId): self
    {
        $this->tenantId = $tenantId;
        return $this;
    }

    public function withOwnerId(string $ownerId): self
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    public function  thresholdDays(int $days): self
    {
        $this->updateThresholdDays = $days;
        return $this;
    }

    /**
     * @param Booking[] $existingBookings
     */
    public function withExistingBookings(array $existingBookings): self
    {
        $this->existingBookings = $existingBookings;
        return $this;
    }

    public function build(): Booking
    {
        return new Booking(
            id: BookingId::of($this->id),
            listingId: ListingId::of($this->listingId),
            dates: BookingDates::of(new DateTimeImmutable($this->startDates), new DateTimeImmutable($this->endDates)),
            numberOfGuests: NumberOfGuests::of($this->numberOfGuests),
            maxCapacity: Capacity::of($this->maxCapacity),
            tenantId: TenantId::of($this->tenantId),
            ownerId: OwnerId::of($this->ownerId),
            existingBookings: $this->existingBookings,
            now: new DateTimeImmutable($this->actualDate),
            updateThresholdDays: $this->updateThresholdDays
        );
    }
}
