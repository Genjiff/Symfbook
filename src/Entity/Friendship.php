<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FriendshipRepository")
 */
class Friendship
{
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';


    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User", inversedBy="myFriends")
     * @ORM\JoinColumn(name="user1", referencedColumnName="id", nullable=false)
     */
    private $user1;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="User", inversedBy="friendsWithMe")
     * @ORM\JoinColumn(name="user2", referencedColumnName="id", nullable=false)
     */
    private $user2;

    /**
     * @ORM\Column(type="string")
     */
    private $status;

    /**
     * @return User
     */
    public function getUser1()
    {
        return $this->user1;
    }

    /**
     * @param User $user1
     */
    public function setUser1($user1): void
    {
        $this->user1 = $user1;
    }

    /**
     * @return User
     */
    public function getUser2()
    {
        return $this->user2;
    }

    /**
     * @param User $user2
     */
    public function setUser2($user2): void
    {
        $this->user2 = $user2;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status): void
    {
        if (!in_array($status, array(self::STATUS_CONFIRMED, self::STATUS_PENDING))) {
            throw new \InvalidArgumentException("Invalid status");
        }
        $this->status = $status;
    }
}
