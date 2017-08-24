<?php
namespace AppBundle\Role;

use Edweld\AclBundle\Entity\Role;
use Edweld\AclBundle\Entity\Actions;
use Edweld\AclBundle\ACL;
use AppBundle\Entity\Circle;
use AppBundle\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 */

class CircleBaseRole extends Role 
{
	/**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Circle", inversedBy="objectRoles")
     */
    protected $circleObject;

    public function __construct(User $user, Circle $circleObject)
    {
        $this->circleObject = $circleObject;

        parent::__construct($user);
    }

    public function createAuthorizations(ACL $acl)
    {
        $acl->allow(
            $this,
            new Actions([ Actions::VIEW ]),
            $this->circleObject
        );
    }
}
