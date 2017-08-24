<?php

namespace AppBundle\Role;

use AppBundle\Role\CircleBaseRole;
use Edweld\AclBundle\ACL;
use Edweld\AclBundle\Entity\Actions;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(readOnly=true)
 */

class CircleEditorRole extends CircleBaseRole
{
    public function createAuthorizations(ACL $acl)
    {
        // Administrators are able to do everything on ALL the articles
        $acl->allow(
            $this,
            Actions::all(),
            new ClassResource('AppBundle\Entity\Circle')
        );
    }
}
