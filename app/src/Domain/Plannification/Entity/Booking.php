<?php

namespace Domain\Plannification\Entity;

use DateTimeImmutable;
use InvalidArgumentException;
use Domain\Plannification\ValueObject\OwnerId;
use Domain\Plannification\ValueObject\Capacity;
use Domain\Plannification\ValueObject\TenantId;
use Domain\Plannification\ValueObject\BookingId;
use Domain\Plannification\ValueObject\ListingId;
use Domain\Plannification\ValueObject\BookingDates;
use Domain\Plannification\ValueObject\BookingStatus;
use Domain\Plannification\ValueObject\NumberOfGuests;

class Booking
{
    private BookingStatus $status;

    /**
     * Booking constructor.
     * @param BookingId $id
     * @param ListingId $listingId
     * @param BookingDates $dates
     * @param NumberOfGuests $numberOfGuests
     * @param Capacity $maxCapacity
     * @param DateTimeImmutable $now
     * @param Booking[] $existingBookings
     */
    public function __construct(
        public readonly BookingId $id,
        private ListingId $listingId,
        private BookingDates $dates,
        private NumberOfGuests $numberOfGuests,
        private Capacity $maxCapacity,
        private TenantId $tenantId,
        private OwnerId $ownerId,
        private DateTimeImmutable $now,
        private readonly int $updateThresholdDays = 3,
        private array $existingBookings = []
    ) {
        $this->setDates($dates);
        $this->setNumberOfGuests($numberOfGuests);
        $this->setCapacity($this->maxCapacity->getValue());
        $this->status = BookingStatus::PENDING;
    }

    public function getbookingId(): BookingId
    {
        return $this->id;
    }

    public function getTenantId(): TenantId
    {
        return $this->tenantId;
    }

    public function getOwnerId(): OwnerId
    {
        return $this->ownerId;
    }

    public function getListingId(): ListingId
    {
        return $this->listingId;
    }

    public function setOwnerId(string $id): self
    {
        $this->ownerId = OwnerId::of($id);
        return $this;
    }

    public function setListingId(string $id): self
    {
        $this->listingId = ListingId::of($id);
        return $this;
    }

    /**
     * Sets the booking dates and checks for availability and conflicts.
     * @param BookingDates $dates
     * @throws InvalidArgumentException if the dates are not available, conflict with existing bookings,
     * or are within 3 days of the current date.
     */
    private function setDates(BookingDates $dates): void
    {
        if (!$this->areDatesAvailable($dates)) {
            throw new InvalidArgumentException('The requested dates are not available.');
        }

        if ($this->isTooLateToUpdateDates()) {
            throw new InvalidArgumentException('Cannot modify booking within 3 days of start date.');
        }

        $this->dates = $dates;
    }

    /**
     * Sets the capacity for the booking and checks if it's within the allowable time frame.
     * @param int $capacity
     * @throws InvalidArgumentException if trying to set capacity within 3 days of the start date.
     */
    public function setCapacity(int $capacity): void
    {
        if ($this->isTooLateToUpdateDates()) {
            throw new InvalidArgumentException('Cannot change capacity within 3 days of start date.');
        }

        $this->maxCapacity = Capacity::of($capacity);
    }

    /**
     * Checks if the booking dates overlap with existing bookings.
     * @param BookingDates $dates
     * @return bool true if the dates are available, false otherwise.
     */
    private function areDatesAvailable(BookingDates $dates): bool
    {
        return !$this->overlapsWith($this->existingBookings, $dates);
    }

    /**
     * Check for overlap between two booking dates.
     * @param Booking[] $existingBookings
     * @param BookingDates $newDates
     * @return bool true if dates overlaps, false otherwise.
     */
    private function overlapsWith(array $existingBookings, BookingDates $newDates): bool
    {
        foreach ($existingBookings as $existingBooking) {
            if ($existingBooking->dates->startDate < $newDates->endDate && $existingBooking->dates->endDate > $newDates->startDate) {
                return true;
            }
        }
        return false;
    }

    /**
     * Sets the number of guests for the booking and checks if it exceeds the maximum capacity.
     * @param NumberOfGuests $numberOfGuests
     * @throws InvalidArgumentException if the number of guests exceeds the maximum capacity.
     */
    private function setNumberOfGuests(NumberOfGuests $numberOfGuests): void
    {
        if ($numberOfGuests->value > $this->maxCapacity->getValue()) {
            throw new InvalidArgumentException('The number of guests exceeds the maximum capacity.');
        }

        $this->numberOfGuests = NumberOfGuests::of($numberOfGuests->value);
    }

    public function getNumberOfGuest(): NumberOfGuests
    {
        return $this->numberOfGuests;
    }

    /**
     * Confirms the booking if it's currently pending.
     * @throws InvalidArgumentException if the booking is not in a pending state.
     */
    public function confirmBooking(): void
    {
        if ($this->status !== BookingStatus::PENDING) {
            throw new InvalidArgumentException('Only pending bookings can be confirmed.');
        }

        $this->status = BookingStatus::CONFIRMED;
    }

    /**
     * Cancels the booking if it's currently confirmed.
     * @throws InvalidArgumentException if the booking is not in a confirmed state
     * or if it's within 3 days of the start date.
     */
    public function cancelBooking(): void
    {
        if ($this->isTooLateToUpdateDates()) {
            throw new InvalidArgumentException('Cannot cancel booking within 3 days of start date.');
        }

        if ($this->status !== BookingStatus::CONFIRMED) {
            throw new InvalidArgumentException('Only confirmed bookings can be cancelled.');
        }

        $this->status = BookingStatus::CANCELLED;
    }

    /**
     * Modifies the booking dates and number of guests, subject to certain restrictions.
     * @param BookingDates $newDates
     * @param int $newNumberOfGuests
     * @throws InvalidArgumentException if the booking cannot be modified due to policy or timing restrictions.
     */
    public function modifyBooking(BookingDates $newDates, int $newNumberOfGuests): void
    {
        if ($this->status !== BookingStatus::CONFIRMED) {
            throw new InvalidArgumentException('Only confirmed bookings can be modified.');
        }

        if ($this->isTooLateToUpdateDates()) {
            throw new InvalidArgumentException('Cannot modify booking within 3 days of start date.');
        }

        $this->setDates($newDates);
        $this->setNumberOfGuests(NumberOfGuests::of($newNumberOfGuests));
    }

    /**
     * Checks if it's too late to update booking dates.
     * @return bool true if it's within 3 days of start date, false otherwise.
     */
    public function isTooLateToUpdateDates(): bool
    {
        $dateDiff = $this->now->diff($this->dates->startDate)->days;
        return $dateDiff <= $this->updateThresholdDays;
    }
}
