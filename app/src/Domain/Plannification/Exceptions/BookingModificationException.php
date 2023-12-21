<?

namespace Domain\Plannification\Exceptions;

use Exception;

class BookingModificationException extends Exception
{
    public function __construct(string $message = "Booking cannot be modified due to policy or timing restrictions.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
