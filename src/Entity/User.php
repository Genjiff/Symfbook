<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields="email", message="Email already registered.")
 * @UniqueEntity(fields="username", message="Username already taken")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $fullname;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(name="about_me", type="string", length=2000, nullable=true)
     */
    private $aboutMe = null;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $education = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $age = null;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $location = null;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\File(mimeTypes={"image/jpeg", "image/png"}, mimeTypesMessage="Only JPEG and PNG images are allowed.")
     */
    private $profilePicture = null;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="userFrom", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $sentPosts;

    /**
     * @ORM\OneToMany(targetEntity="Post", mappedBy="userTo", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $receivedPosts;

    /**
     * @ORM\OneToMany(targetEntity="Friendship", mappedBy="user1")
     */
    private $myFriends;

    /**
     * @ORM\OneToMany(targetEntity="Friendship", mappedBy="user2")
     */
    private $friendsWithMe;

    /**
     * @var User[]
     */
    private $allFriends;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getFullname()
    {
        return $this->fullname;
    }

    /**
     * @param string $fullname
     */
    public function setFullname($fullname): void
    {
        $this->fullname = $fullname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    /**
     * @return string
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
    }

    /**
     * @param string $aboutMe
     */
    public function setAboutMe($aboutMe): void
    {
        $this->aboutMe = $aboutMe;
    }

    /**
     * @return string
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @param string $education
     */
    public function setEducation($education): void
    {
        $this->education = $education;
    }

    /**
     * @return integer
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param integer $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * @param string $profilePicture
     */
    public function setProfilePicture($profilePicture): void
    {
        $this->profilePicture = $profilePicture;
    }

    /**
     * @return array
     */
    public function getSentPosts()
    {
        return $this->sentPosts->toArray();
    }

    /**
     * @return array
     */
    public function getReceivedPosts()
    {
        return $this->receivedPosts->toArray();
    }

    /**
     * @return array
     */
    public function getMyFriends()
    {
        $myFriends = array();
        $friendshipArray = $this->myFriends->toArray();

        /** @var Friendship $myFriend */
        foreach ($friendshipArray as $myFriend) {
            array_push($myFriends, $myFriend->getUser2());
        }

        return $myFriends;
    }

    /**
     * @return array
     */
    public function getFriendsWithMe()
    {
        //return $this->friendsWithMe->toArray();
        $friendsWithMe = array();
        $friendshipArray = $this->friendsWithMe->toArray();

        /** @var Friendship $friend */
        foreach ($friendshipArray as $friend) {
            array_push($friendsWithMe, $friend->getUser1());
        }

        return $friendsWithMe;
    }

    /**
     * @return array
     */
    public function getAllFriends() {
        $myFriends = $this->getMyFriends();
        $friendsWithMe = $this->getFriendsWithMe();

        return array_merge($myFriends, $friendsWithMe);
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->fullname,
            $this->email,
            $this->password,
            $this->plainPassword
        ));
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->fullname,
            $this->email,
            $this->password,
            $this->plainPassword
            ) = unserialize($serialized);
    }

    public function __construct() {
        $this->receivedPosts = new ArrayCollection();
        $this->sentPosts = new ArrayCollection();
        $this->myFriends = new ArrayCollection();
        $this->friendsWithMe = new ArrayCollection();
    }
}
