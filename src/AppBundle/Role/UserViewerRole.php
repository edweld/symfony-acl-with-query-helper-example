<?php

namespace AppBundle\Role;

use Edweld\AclBundle\Entity\Role;
use Edweld\AclBundle\Entity\Actions;
use Edweld\AclBundle\ACL;

use AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 */

class UserViewerRole extends Role 
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="objectRoles")
     */
    protected $userObject;

    public function __construct(User $user, User $userObject )
    {
        $this->userObject = $userObject;

        parent::__construct($user);
    }

    public function createAuthorizations(ACL $acl)
    {
        $acl->allow(
            $this,
            new Actions([ Actions::VIEW ]),
            $this->userObject
        );
    }
}
