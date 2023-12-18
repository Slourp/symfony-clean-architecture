<?

namespace Infrastructure\Symfony\Adapter\View;

use Application\Interface\ViewModel;
use Symfony\Component\HttpFoundation\JsonResponse;

class JsonViewModel extends ViewModel
{
    /**
     * @param array<string, mixed> $data
     */
    public function __construct(
        private int $statusCode,
        private array $data
    ) {
    }

    public function getResponse(): JsonResponse
    {
        return new JsonResponse($this->data, $this->statusCode);
    }
}
