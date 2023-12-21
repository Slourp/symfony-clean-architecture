<?

namespace Domain\Plannification\Exceptions;

use Exception;

class InvalidTenantException extends Exception
{
    public function __construct(string $message = "The tenant ID is invalid or unauthorized.", int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
