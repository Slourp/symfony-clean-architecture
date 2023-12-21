<?

namespace Domain\Plannification\Exceptions;

use Exception;

class UnauthorizedModificationException extends Exception
{
    public function __construct(string $message = "Unauthorized modification attempt.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
