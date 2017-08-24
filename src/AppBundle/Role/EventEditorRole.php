<?php

namespace AppBundle\Role;

use AppBundle\Role\EventBaseRole;
use Edweld\AclBundle\ACL;
use Edweld\AclBundle\Entity\Actions;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 */

class EventEditorRole extends EventBaseRole
{
   public function createAuthorizations(ACL $acl)
    {
        $acl->allow(
            $this,
            new Actions([ Actions::EDIT, Actions::VIEW, Actions::DELETE ]),
            $this->eventObject
        );
    }
}
