<?php

namespace Domain\RentalContext\Entity;

use InvalidArgumentException;
use Domain\RentalContext\ValueObject\UserId;
use Domain\AuthContext\ValueObject\BookingId;
use Domain\RentalContext\ValueObject\Capacity;
use Domain\RentalContext\ValueObject\ListingId;
use Domain\RentalContext\ValueObject\BookingDates;
use Domain\RentalContext\ValueObject\BookingStatus;
use Domain\RentalContext\ValueObject\NumberOfGuests;

class Booking
{
    private BookingStatus $status;

    /**
     * Booking constructor.
     * @param BookingId $id
     * @param UserId $userId
     * @param ListingId $listingId
     * @param BookingDates $dates
     * @param NumberOfGuests $numberOfGuests
     * @param Capacity $maxCapacity
     * @param Booking[] $existingBookings
     */
    public function __construct(
        public readonly BookingId $id,
        private UserId $userId,
        private ListingId $listingId,
        private BookingDates $dates,
        private NumberOfGuests $numberOfGuests,
        private Capacity $maxCapacity,
        private array $existingBookings = []
    ) {

        $this->setDates($dates);
        $this->setNumberOfGuests($numberOfGuests);
        $this->status = BookingStatus::PENDING;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getListingId(): ListingId
    {
        return $this->listingId;
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
        if ($numberOfGuests->value > $this->maxCapacity->value) {
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
