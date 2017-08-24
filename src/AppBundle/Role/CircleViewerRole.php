<?php

namespace AppBundle\Role;

use AppBundle\Role\CircleBaseRole;

use AppBundle\Entity\Circle;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(readOnly=true)
 */

class CircleViewerRole extends CircleBaseRole 
{
}