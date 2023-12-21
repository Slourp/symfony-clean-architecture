<?

namespace Domain\Plannification\Exceptions;

class InvalidCapacityException extends \Exception
{
    public function __construct(string $message = "Specified capacity is invalid.", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
