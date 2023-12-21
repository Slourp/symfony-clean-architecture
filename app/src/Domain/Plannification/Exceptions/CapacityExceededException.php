<?

namespace Domain\Plannification\Exceptions;

use Exception;

class CapacityExceededException extends Exception
{
    public function __construct(string $message = "The number of guests exceeds the maximum capacity.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
