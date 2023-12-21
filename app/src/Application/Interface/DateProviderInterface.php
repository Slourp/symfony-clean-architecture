<?

namespace Application\Interface;

use DateTimeImmutable;

interface DateProviderInterface
{
    public function getCurrentDate(): DateTimeImmutable;
}
