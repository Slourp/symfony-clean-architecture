<?

namespace Domain\Plannification\Exceptions;

use Exception;

class OverlappingBookingException extends Exception
{
    public function __construct(string $message = "The booking dates overlap with an existing booking.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
