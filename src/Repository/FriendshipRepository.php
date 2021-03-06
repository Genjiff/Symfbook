<?php

namespace App\Repository;

use App\Entity\Friendship;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

class FriendshipRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Friendship::class);
    }

    /**
     * @param User $user
     * @return Friendship
     */
    public function findConfirmedFriendsByUser(User $user) {
        return $this->createQueryBuilder('f')
            ->where('f.user1 = :user OR f.user2 = :user')
            ->andWhere('f.status = :confirmed')
            ->setParameter('user', $user)
            ->setParameter('confirmed', 'confirmed')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user1
     * @param User $user2
     * @return null|User
     * @throws NonUniqueResultException
     */
    public function findFriendship(User $user1, User $user2) {
        return $this->createQueryBuilder('f')
            ->where('f.user1 = :user1 OR f.user1 = :user2')
            ->andWhere('f.user2 = :user1 OR f.user2 = :user2')
            ->setParameters(array('user1' => $user1, 'user2' => $user2))
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param User $user1
     * @param User $user2
     * @return NonUniqueResultException|false|string
     */
    public function checkFriendship(User $user1, User $user2) {
        try {
            $cf = $this->createQueryBuilder('f')
                ->where('f.user1 = :user1 AND f.user2 = :user2')
                ->orWhere('f.user1 = :user2 AND f.user2 = :user1')
                ->setParameter('user1', $user1)
                ->setParameter('user2', $user2)
                ->getQuery()
                ->getOneOrNullResult();

            /** @var Friendship $fs */
            if ($cf != null) {
                return $cf->getStatus();
            } else {
                return false;
            }
        } catch (NonUniqueResultException $e) {
            return $e;
        }
    }

    /**
     * @param User $user
     * @return Friendship
     */
    public function findPendingRequestsByUser(User $user) {
        return $this->createQueryBuilder('f')
            ->where('f.user2 = :user')
            ->andWhere('f.status = :pending')
            ->setParameter('user', $user)
            ->setParameter('pending', 'pending')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user
     * @return integer
     * @throws NonUniqueResultException
     */
    public function countPendingRequestsByUser(User $user) {
        return $this->createQueryBuilder('f')
            ->select('count(f.user2)')
            ->where('f.user2 = :user')
            ->andWhere('f.status = :pending')
            ->setParameter('user', $user)
            ->setParameter('pending', 'pending')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /**
     * @param User $user
     * @return integer
     * @throws NonUniqueResultException
     */
    public function countFriendsByUser(User $user) {
        return $this->createQueryBuilder('f')
            ->select('count(f.user1)')
            ->where('f.user1 = :user OR f.user2 = :user')
            ->andWhere('f.status = :confirmed')
            ->setParameter('user', $user)
            ->setParameter('confirmed', 'confirmed')
            ->getQuery()
            ->getSingleScalarResult();
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('f')
            ->where('f.something = :value')->setParameter('value', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
