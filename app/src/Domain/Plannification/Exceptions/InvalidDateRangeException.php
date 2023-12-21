<?

namespace Domain\Plannification\Exceptions;

class InvalidDateRangeException extends \Exception
{
    public function __construct(string $message = "The provided date range is invalid.", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
