<?php

namespace Infrastructure\Symfony\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Domain\AuthContext\Entity\User as EntityUser;
use Domain\AuthContext\Gateway\UserRepositoryWriteI;
use Infrastructure\Symfony\Entity\User;

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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function getAllUsers()
    {
        $users = $this->registry->findAll();
        return $users;
    }

    public function registerUser(EntityUser $user): string
    {
        $user =  (new User())
            ->setUsername($user->getUserName()->value)
            ->setEmail($user->getEmail()->value)
            ->setPassword($user->getPassword()->value);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        return $user->getId();
    }
}
