<?php
/**
 * Created by PhpStorm.
 * User: Lucas
 * Date: 15/01/2018
 * Time: 18:03
 */

namespace App\Service;


use App\Entity\Friendship;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class FriendService {
    protected $user;
    protected $friendship;

    public function __construct(EntityManagerInterface $em, TokenStorageInterface $tokenStorage)
    {
        if ($tokenStorage->getToken() != null) {
            $this->user = $tokenStorage->getToken()->getUser();
        }
        $this->friendship = $em->getRepository(Friendship::class);
    }

    /**
     * @return int
     */
    public function friendRequestsCount() {
        try {
            return $this->friendship->countPendingRequestsByUser($this->user);
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }

    /**
     * @param User $user
     * @return int
     */
    public function friendsCount(User $user) {
        try {
            return $this->friendship->countFriendsByUser($user);
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }
}