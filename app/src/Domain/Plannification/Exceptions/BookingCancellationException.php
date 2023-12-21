<?

namespace Domain\Plannification\Exceptions;

class BookingCancellationException extends \Exception
{
    public function __construct(string $message = "Error in booking cancellation.", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
