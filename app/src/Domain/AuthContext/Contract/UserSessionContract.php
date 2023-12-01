<?

namespace Domain\AuthContext\Contract;

use Domain\AuthContext\Entity\User;

interface UserSessionContract
{
    public function create(User $user): bool;
}
