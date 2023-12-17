<?

namespace Domain\AuthContext\Exceptions;

class InvalidPasswordException extends \Exception
{
    public function __construct(
        string $message = "Password is invalid.",
        int $code = 0,
        \Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
