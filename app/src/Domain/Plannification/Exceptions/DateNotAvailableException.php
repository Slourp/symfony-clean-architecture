<?

namespace Domain\Plannification\Exceptions;

use Exception;

class DateNotAvailableException extends Exception
{
    public function __construct(string $message = "The requested dates are not available.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
