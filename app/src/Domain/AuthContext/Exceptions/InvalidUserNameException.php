<?

namespace Domain\AuthContext\Exceptions;


class InvalidUserNameException extends \Exception
{
    public function __construct(string $message = "User name is invalid.", int $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
