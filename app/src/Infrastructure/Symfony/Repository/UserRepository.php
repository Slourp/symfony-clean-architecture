<?php

namespace Infrastructure\Symfony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\AuthContext\Entity\User as EntityUser;
use Domain\AuthContext\Gateway\UserRepositoryWriteI;
use Domain\AuthContext\ValueObject\Email;
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
        private  UserPasswordHasherInterface $passwordEncoder
    ) {
        parent::__construct($registry, User::class);
    }

    public function getAllUsers()
    {
        $users = $this->registry->findAll();
        return $users;
    }

    public function findByUsername(string $username): ?EntityUser
    {
        $userDoctrine = $this->findOneBy(['username' => $username]);

        if (!$userDoctrine) {
            return null;
        }

        return new EntityUser(
            userName: UserName::of($userDoctrine->getUsername()),
            email: Email::of($userDoctrine->getEmail()),
            password: null,
            id: $userDoctrine->getId()
        );
    }

    public function registerUser(EntityUser $user): UserId
    {
        $userDoctrine = new User();
        $userDoctrine->setUsername($user->getUserName()->value)
            ->setEmail($user->getEmail()->value)
            ->setPassword(
                $this->passwordEncoder->hashPassword(
                    $userDoctrine,
                    $user->getPassword()->value
                )
            );

        $this->getEntityManager()->persist($userDoctrine);
        $this->getEntityManager()->flush();

        return UserId::of($userDoctrine->getId());
    }

    public function emailExists(Email $email): bool
    {
        $test = $this->createQueryBuilder('u')
            ->select('count(u.id)')
            ->where('u.email = :email')
            ->setParameter('email', $email->value)
            ->getQuery()
            ->getSingleScalarResult() > 0;
        return $test;
    }
}
