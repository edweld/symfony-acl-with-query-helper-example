<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\User;
use AppBundle\Entity\Circle;
use Edweld\AclBundle\Entity\EntityResource;
use Edweld\AclBundle\Entity\ResourceInterface;
use AppBundle\Role\EventViewerRole;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EventRepository")
 */
class Event implements EntityResource   
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
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToMany(targetEntity="User")
     * @ORM\JoinTable(name="event_users",
     *      joinColumns={@ORM\JoinColumn(name="event_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     *      )
     */
    private $users;

    /**
     * @ORM\ManyToOne(targetEntity="Circle", inversedBy="events")
     */
    private $circle;

    /**
     * @ORM\Column(name="everyone", type="boolean")
     */
    private $everyone;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Role\EventViewerRole", mappedBy="event", cascade={"remove"})
     */
    protected $objectRoles;


    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Event
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Event
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    public function addUser(User $user)
    {
        $this->users = $user;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function removeUser(User $user)
    {
        return $this->users->removeElement($user);
    }

    public function setCircle(Circle $circle)
    {
        $this->circle = $circle;

    }

    public function getCircle()
    {
        return $this->circle;
    }

    public function __toString()
    {
        return $this->name;
    }
    public function setEveryone($everyone)
    {
        $this->everyone = $everyone;
    }
    public function getEveryone()
    {
        return $this->everyone;
    }
}


