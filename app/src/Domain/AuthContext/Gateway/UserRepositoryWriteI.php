<?

namespace Domain\AuthContext\Gateway;

use Domain\AuthContext\Entity\User;

interface UserRepositoryWriteI
{
    /**
     * @return string 
     */
    public function registerUser(User $user): string;

    public function findByUsername(string $username): ?User;

    /**
     * @return User|null
     */
    public function findByEmail(string $email): ?User;
}
