<?

namespace Domain\AuthContext\Exceptions;

class InvalidPasswordException extends \Exception
{
    public function __construct(
        $message = "Password is invalid.",
        $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
