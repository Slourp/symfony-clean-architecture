<?php

namespace Domain\HousingManagement\Entity;

use Domain\HousingManagement\ValueObject\Capacity;
use Domain\HousingManagement\ValueObject\ListingId;
use Domain\HousingManagement\ValueObject\NumberOfGuests;
use Domain\HousingManagement\ValueObject\UserId;
use Domain\Plannification\ValueObject\BookingDates;
use Domain\Plannification\ValueObject\BookingId;
use Domain\Plannification\ValueObject\BookingStatus;
use Domain\Plannification\ValueObject\OwnerId;
use Domain\Plannification\ValueObject\TenantId;
use InvalidArgumentException;


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
        private array $existingBookings = []
    ) {

        $this->setDates($dates);
        $this->setNumberOfGuests($numberOfGuests);
        $this->setCapacity($this->maxCapacity->getValue());
        $this->status = BookingStatus::PENDING;
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
     * @throws InvalidArgumentException if the dates are not available or conflict with existing bookings.
     */
    private function setDates(BookingDates $dates): void
    {
        if (!$this->areDatesAvailable($dates)) {
            throw new InvalidArgumentException('The requested dates are not available.');
        }

        $this->dates = $dates;
    }

    public function setCapacity(int $capacity): void
    {
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
     *
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
     * @throws InvalidArgumentException if the booking is not in a confirmed state.
     */
    public function cancelBooking(): void
    {
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

        $this->setDates($newDates);
        $this->setNumberOfGuests(NumberOfGuests::of($newNumberOfGuests));
    }
}
