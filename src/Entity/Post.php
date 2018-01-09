<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=4000)
     * @Assert\NotBlank()
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sentPosts")
     * @ORM\JoinColumn(name="user_from", referencedColumnName="id", nullable=false)
     */
    private $userFrom;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="receivedPosts")
     * @ORM\JoinColumn(name="user_to", referencedColumnName="id", nullable=false)
     */
    private $userTo;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank()
     */
    private $timestamp;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getUserFrom()
    {
        return $this->userFrom;
    }

    /**
     * @param mixed $userFrom
     */
    public function setUserFrom($userFrom): void
    {
        $this->userFrom = $userFrom;
    }

    /**
     * @return mixed
     */
    public function getUserTo()
    {
        return $this->userTo;
    }

    /**
     * @param mixed $userTo
     */
    public function setUserTo($userTo): void
    {
        $this->userTo = $userTo;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}
