<?

namespace Domain\Plannification\Exceptions;

class InvalidOwnerException extends \Exception
{
    public function __construct(string $message = "The owner ID is invalid or unauthorized.", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
