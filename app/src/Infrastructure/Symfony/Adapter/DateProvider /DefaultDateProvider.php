<?

namespace Infrastructure\Symfony\Adapter\DateProvider;


use Application\Interface\DateProviderInterface;
use DateTimeImmutable;

class DefaultDateProvider implements DateProviderInterface
{
    public function getCurrentDate(): DateTimeImmutable
    {
        return new DateTimeImmutable('now');
    }
}
