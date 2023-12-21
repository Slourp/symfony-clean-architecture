<?php

namespace Domain\Plannification\Entity;

use DateTimeImmutable;
use Domain\Plannification\Exceptions\BookingStateException;
use Domain\Plannification\Exceptions\DateRelatedException;
use Domain\Plannification\Exceptions\ResourceValidationException;
use Domain\Plannification\Factory\ExceptionFactory;
use Domain\Plannification\ValueObject\OwnerId;
use Domain\Plannification\ValueObject\Capacity;
use Domain\Plannification\ValueObject\TenantId;
use Domain\Plannification\ValueObject\BookingId;
use Domain\Plannification\ValueObject\ListingId;
use Domain\Plannification\ValueObject\BookingDates;
use Domain\Plannification\ValueObject\BookingStatus;
use Domain\Plannification\ValueObject\NumberOfGuests;
use InvalidArgumentException;

class Booking
{
    private BookingStatus $status;

    /**
     * Booking constructor.
     * Initializes a new booking instance.
     *
     * @param BookingId $id Unique identifier for the booking.
     * @param ListingId $listingId Identifier for the listing being booked.
     * @param BookingDates $dates Start and end dates for the booking.
     * @param NumberOfGuests $numberOfGuests Number of guests for the booking.
     * @param Capacity $maxCapacity Maximum capacity of the booking.
     * @param DateTimeImmutable $now Current time, used for comparison with booking dates.
     * @param Booking[] $existingBookings Array of existing bookings for overlap checks.
     * @param int $updateThresholdDays Number of days before start date when updates are not allowed.
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

    /**
     * Sets the booking dates and checks for availability and conflicts.
     *
     * @param BookingDates $dates Dates for the booking.
     * @throws BookingStateException if the booking is canceled, or if modifications are made too late.
     * @throws DateRelatedException if the dates are not available, conflict with existing bookings, 
     *                              if the booking is already canceled, or if the end date is beyond 6 months.
     */
    private function setDates(BookingDates $dates): void
    {
        if ($this->status === BookingStatus::CANCELLED) {
            ExceptionFactory::createBookingStateException("Cannot modify the dates of a canceled booking.");
        }

        if ($this->isTooLateToUpdateDates()) {
            ExceptionFactory::createDateRelatedException("Cannot modify booking within 3 days of start date.");
        }

        if (!$this->areDatesAvailable($dates)) {
            ExceptionFactory::createDateRelatedException("The requested dates are not available.");
        }

        $sixMonthsFromNow = (new DateTimeImmutable())->modify('+6 months');
        if ($dates->endDate > $sixMonthsFromNow) {
            ExceptionFactory::createDateRelatedException("Booking cannot be made for dates more than 6 months in advance.");
        }

        $this->dates = $dates;
    }

    /**
     * Sets the capacity for the booking and checks if it's within the allowable time frame.
     *
     * @param int $capacity New capacity for the booking.
     * @throws ResourceValidationException if trying to set capacity within the restricted time frame.
     * @throws InvalidArgumentException if the capacity is wrong.
     */
    private function setCapacity(int $capacity): void
    {
        $this->maxCapacity = Capacity::of($capacity);
    }


    /**
     * Checks if the booking dates overlap with existing bookings.
     *
     * @param BookingDates $dates Dates to check for availability.
     * @throws DateRelatedException if the booking dates overlap with any existing bookings.
     * @return bool True if the dates are available, false otherwise.
     */
    private function areDatesAvailable(BookingDates $dates): bool
    {
        foreach ($this->existingBookings as $existingBooking) {
            if ($existingBooking->dates->startDate < $dates->endDate && $existingBooking->dates->endDate > $dates->startDate) {
                throw ExceptionFactory::createDateRelatedException("The booking dates overlap with an existing booking.");
            }
        }
        return true;
    }


    /**
     * Sets the number of guests for the booking and checks if it exceeds the maximum capacity.
     *
     * @param NumberOfGuests $numberOfGuests Number of guests to be set.
     * @throws ResourceValidationException if the number of guests exceeds the maximum capacity.
     * @throws BookingStateException if the booking is canceled.
     */
    private function setNumberOfGuests(NumberOfGuests $numberOfGuests): void
    {
        if ($this->status === BookingStatus::CANCELLED) {
            ExceptionFactory::createBookingStateException("Cannot update the number of guests for a canceled booking.");
        }

        if ($numberOfGuests->value > $this->maxCapacity->getValue()) {
            ExceptionFactory::createResourceValidationException("The number of guests exceeds the maximum capacity.");
        }

        $this->numberOfGuests = NumberOfGuests::of($numberOfGuests->value);
    }


    /**
     * Confirms the booking if it's currently pending.
     *
     * @throws BookingStateException if the booking is not in a pending state or if it's already canceled.
     */
    public function confirmBooking(): void
    {
        if ($this->status === BookingStatus::CANCELLED) {
            ExceptionFactory::createBookingStateException("Canceled bookings cannot be confirmed.");
        }

        if ($this->status !== BookingStatus::PENDING) {
            ExceptionFactory::createBookingStateException("Only pending bookings can be confirmed.");
        }

        $this->status = BookingStatus::CONFIRMED;
    }


    /**
     * Cancels the booking if it's currently confirmed.
     *
     * @throws BookingStateException if the booking is not in a confirmed state, 
     * if it's within 3 days of the start date, or if it's already cancelled.
     */
    public function cancelBooking(): void
    {
        if ($this->isTooLateToUpdateDates()) {
            ExceptionFactory::createBookingStateException("Cannot cancel booking within 3 days of start date.");
        }

        if ($this->status === BookingStatus::CANCELLED) {
            ExceptionFactory::createBookingStateException("Booking is already cancelled.");
        }

        if ($this->status !== BookingStatus::CONFIRMED) {
            ExceptionFactory::createBookingStateException("Only confirmed bookings can be cancelled.");
        }

        $this->status = BookingStatus::CANCELLED;
    }


    /**
     * Modifies the booking dates and number of guests, subject to certain restrictions.
     *
     * @param BookingDates $newDates New dates for the booking.
     * @param int $newNumberOfGuests New number of guests for the booking.
     * @throws BookingStateException if the booking cannot be modified due to policy or timing restrictions.
     */
    public function modifyBooking(BookingDates $newDates, int $newNumberOfGuests): void
    {
        if ($this->status !== BookingStatus::CONFIRMED) {
            ExceptionFactory::createBookingStateException("Only confirmed bookings can be modified.");
        }

        if ($this->isTooLateToUpdateDates()) {
            ExceptionFactory::createBookingStateException("Cannot modify booking within 3 days of start date.");
        }

        $this->setDates($newDates);
        $this->setNumberOfGuests(NumberOfGuests::of($newNumberOfGuests));
    }

    /**
     * Checks if it's too late to update booking dates.
     *
     * @return bool True if it's within 3 days of start date, false otherwise.
     */
    public function isTooLateToUpdateDates(): bool
    {
        $dateDiff = $this->now->diff($this->dates->startDate)->days;
        return $dateDiff <= $this->updateThresholdDays;
    }
    public function getListingId(): ListingId
    {
        return $this->listingId;
    }
    public function getNumberOfGuests(): NumberOfGuests
    {
        return $this->numberOfGuests;
    }
    public function getTenantId(): TenantId
    {
        return $this->tenantId;
    }
    public function getOwnerId(): OwnerId
    {
        return $this->ownerId;
    }
}
