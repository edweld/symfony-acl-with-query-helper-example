<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Circle;
use AppBundle\Entity\Event;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Edweld\AclBundle\Entity\EntityResource;
use Edweld\AclBundle\Entity\Role;
use Edweld\AclBundle\Entity\SecurityIdentityInterface;

use AppBundle\Role\UserViewerRole;
/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable, EntityResource, SecurityIdentityInterface
{


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var bool
     *
     * @ORM\Column(name="isActive", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\ManyToMany(targetEntity="Circle", inversedBy="users")
     * @ORM\JoinTable(name="users_circles")
     */
    private $circles;

    /**
     * @ORM\ManyToMany(targetEntity="Event", mappedBy="users")
     */
    private $events;

    /**
     * @var Role[]
     * @ORM\OneToMany(targetEntity="Edweld\AclBundle\Entity\Role", mappedBy="securityIdentity",
     *     cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Role\UserViewerRole", mappedBy="user", cascade={"remove"})
     */
    protected $objectRoles;

    public function __construct()
    {
        $this->circles = new ArrayCollection();
        $this->events = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->objectRoles = new ArrayCollection();
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return bool
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    public function addCircle(Circle $circle)
    {
        $this->circles[] = $circle;
    }

    public function getCircles()
    {
        return $this->circles;
    }

    public function removeCircle(Circle $circle)
    {
        return $this->circles->removeElement($circle);
    }

    public function addEvent(Event $event)
    {
        $this->events[] = $event;
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function removeEvent(Event $event)
    {
        return $this->events->removeElement($event);
    }

    public function getRoles()
    {
        return $this->roles->toArray();
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    public function getSalt()
    {
        return null;
    }

    public function __toString(){
        return $this->username;
    }

    public function addRole(Role $role)
    {
        $this->roles[] = $role;
    }
    public function removeRole(Role $role)
    {
        $this->roles->removeElement($role);
    }

}

