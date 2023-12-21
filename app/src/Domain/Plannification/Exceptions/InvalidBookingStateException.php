<?

namespace Domain\Plannification\Exceptions;

use Exception;

class InvalidBookingStateException extends Exception
{
    public function __construct(string $message = "Invalid operation for the current booking state.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
