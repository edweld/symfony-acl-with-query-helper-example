<?php
namespace AppBundle\Role;

use Edweld\AclBundle\Entity\Role;
use Edweld\AclBundle\Entity\Actions;
use Edweld\AclBundle\ACL;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

class EventBaseRole extends Role
{
	/**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Event", inversedBy="objectRoles")
     */
    protected $eventObject;

    public function __construct(User $user, Event $eventObject)
    {
        $this->eventObject = $eventObject;

        parent::__construct($user);
    }

    public function createAuthorizations(ACL $acl)
    {
        $acl->allow(
            $this,
            new Actions([ Actions::VIEW ]),
            $this->eventObject
        );
    }

}
