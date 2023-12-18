<?php

namespace Infrastructure\Symfony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\AuthContext\Entity\User as EntityUser;
use Domain\AuthContext\Gateway\UserRepositoryWriteI;
use Domain\AuthContext\ValueObject\Email;
use Domain\AuthContext\ValueObject\Password;
use Domain\AuthContext\ValueObject\UserName;
use Domain\RentalContext\ValueObject\UserId;
use Infrastructure\Symfony\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryWriteI
{
    public function __construct(
        ManagerRegistry $registry,
        private UserPasswordHasherInterface $passwordEncoder
    ) {
        parent::__construct($registry, User::class);
    }

    /**
     * @return EntityUser[]
     */
    /**
     * @return EntityUser[]
     */
    public function getAllUsers(): array
    {
        $doctrineUsers = $this->findAll();

        $users = array_map(function (User $user) {
            $email = $user->getEmail() !== null ? Email::of($user->getEmail()) : null;
            $password = $user->getPassword() !== null ? Password::of($user->getPassword()) : null;
            $id = null;
            if ($user->getId() !== null) {
                $id = UserId::of($user->getId()->toRfc4122());
            }

            // Skip creation of EntityUser if email or id is null
            if ($email === null || $id === null) {
                return null;
            }

            return new EntityUser(
                userName: UserName::of($user->getUsername()),
                email: $email,
                password: $password,
                id: $id
            );
        }, $doctrineUsers);

        // Filter out null values
        return array_filter($users, fn ($user) => $user !== null);
    }

    public function findByUsername(string $username): ?EntityUser
    {
        $userDoctrine = $this->findOneBy(['username' => $username]);

        if (!$userDoctrine) return null;

        $email = $userDoctrine->getEmail() !== null ? Email::of($userDoctrine->getEmail()) : null;
        $id = $userDoctrine->getId() !== null ? $userDoctrine->getId()->toRfc4122() : null;

        if ($email === null || $id === null) return null;

        return new EntityUser(
            userName: UserName::of($userDoctrine->getUsername()),
            email: $email,
            password: null,
            id: UserId::of($id)
        );
    }

    public function registerUser(EntityUser $user): UserId
    {
        $userDoctrine = new User();
        $userDoctrine->setUsername($user->getUserName()->value)
            ->setEmail($user->getEmail()->value);

        $password = $user->getPassword();

        if ($password !== null) {
            $hashedPassword = $this->passwordEncoder->hashPassword(
                $userDoctrine,
                $password->value
            );
            $userDoctrine->setPassword($hashedPassword);
        }

        $this->getEntityManager()->persist($userDoctrine);
        $this->getEntityManager()->flush();

        $doctrineId = $userDoctrine->getId();

        if ($doctrineId === null) throw new \RuntimeException("Failed to retrieve the user ID after persisting.");

        return UserId::of($doctrineId->toRfc4122());
    }


    public function emailExists(Email $email): bool
    {
        return $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.email = :email')
            ->setParameter('email', $email->value)
            ->getQuery()
            ->getSingleScalarResult() > 0;
    }
}
