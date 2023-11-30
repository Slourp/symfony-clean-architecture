<?php

namespace Tests\Unit\AuthContext\Repository;

use Domain\AuthContext\Entity\User;
use Domain\AuthContext\Gateway\UserRepositoryWriteI;

class InMemoryUserRepository implements UserRepositoryWriteI
{
    /**
     * @var User[]
     */
    private array $users = [];

    public function registerUser(User $user): string
    {
        $this->users[] = $user;
        return $user?->id;
    }

    public function findByUsername(string $username): ?User
    {
        $users = array_filter($this->users, fn (User $user) => $user->getUsername()->value === $username);

        return $users ? reset($users) : null;
    }
}
