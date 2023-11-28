<?

namespace Infrastructure\Symfony\Adapter\View;

use Application\Interface\ViewModel;
use Symfony\Component\Console\Style\SymfonyStyle;

class CliViewModel extends ViewModel
{
    public function __construct(private \Closure $handler)
    {
    }

    public function getResponse(SymfonyStyle $io): int
    {
        return ($this->handler)($io);
    }
}
