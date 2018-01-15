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

    public function findConfirmedFriendsByUser(User $user) {
        return $this->createQueryBuilder('f')
            ->where('f.user1 = :user OR f.user2 = :user')
            ->andWhere('f.status = :confirmed')
            ->setParameter('user', $user)
            ->setParameter('confirmed', 'confirmed')
            ->orderBy('f.id', 'Asc')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param User $user1
     * @param User $user2
     * @return mixed
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
