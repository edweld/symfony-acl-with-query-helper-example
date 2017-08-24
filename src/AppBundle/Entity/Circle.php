<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;
use Edweld\AclBundle\Entity\EntityResource;
use AppBundle\Role\CircleBaseRole;


/**
 * Circle
 *
 * @ORM\Table(name="circle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CircleRepository")
 */
class Circle implements EntityResource 
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="circles")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity="Event", mappedBy="circle")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Role\CircleBaseRole", mappedBy="circle", cascade={"remove"})
     */
    protected $objectRoles;

    public function __construct() {
        $this->users = new ArrayCollection();
        $this->events = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Circle
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;

    }

    public function addUser(User $user)
    {
        $user->addCircle($this);
        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function removeUser(User $user)
    {
        return $this->users->removeElement($user);
    }

    public function getEvents()
    {
        return $this->events;
    }
    public function addEvent(Event $event)
    {
        $this->events[] = $event;
    }
    public function __toString()
    {
        return $this->name;
    }
}

