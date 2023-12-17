<?php

namespace Domain\AuthContext\Gateway;

use Domain\AuthContext\Entity\User;
use Domain\AuthContext\ValueObject\Email;
use Domain\RentalContext\ValueObject\UserId;

interface UserRepositoryWriteI
{
    /**
     * Registers a user and returns their ID.
     *
     * @param User $user The user to register.
     * @return UserId The ID of the registered user.
     */
    public function registerUser(User $user): UserId;

    /**
     * Checks if an email is already in use.
     *
     * @param Email $email The email to check.
     * @return bool True if the email exists, false otherwise.
     */
    public function emailExists(Email $email): bool;

    /**
     * Finds a user by their username.
     *
     * @param string $username The username to search for.
     * @return User|null The found user or null if not found.
     */
    public function findByUsername(string $username): ?User;
}
