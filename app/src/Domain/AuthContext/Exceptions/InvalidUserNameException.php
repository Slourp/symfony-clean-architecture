<?

namespace Domain\AuthContext\Exceptions;


class InvalidUserNameException extends \Exception
{
    public function __construct($message = "User name is invalid.", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
