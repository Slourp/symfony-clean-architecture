<?

namespace Domain\AuthContext\Exceptions;

class InvalidEmailException extends \Exception
{
    public function __construct(string $message = "Email is invalid.", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
