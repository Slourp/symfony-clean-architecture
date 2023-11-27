<?

namespace Domain\AuthContext\Exceptions;

class InvalidEmailException extends \Exception
{
    public function __construct($message = "Email is invalid.", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
