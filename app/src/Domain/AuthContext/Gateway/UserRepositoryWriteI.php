<?

namespace Domain\AuthContext\Gateway;

use Domain\AuthContext\Entity\User;

interface UserRepositoryWriteI
{
    /**
     * @return string 
     */
    public function registerUser(User $user): string;
}
