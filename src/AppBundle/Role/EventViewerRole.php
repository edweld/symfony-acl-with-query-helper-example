<?php

namespace AppBundle\Role;

use AppBundle\Entity\Event;
use AppBundle\Entity\User;

use AppBundle\Role\EventBaseRole;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(readOnly=true)
 */

class EventViewerRole extends EventBaseRole
{
}