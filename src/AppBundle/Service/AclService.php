<?php

namespace AppBundle\Service;

use Edweld\AclBundle\Model\ContainerTrait;

use AppBundle\Role\EventEditorRole;
use AppBundle\Role\EventViewerRole;
use AppBundle\Role\UserViewerRole;
use AppBundle\Role\CircleViewerRole;
use Edweld\AclBundle\Entity\Actions;

/**
 * 
 * @author Ed Weld <edward.weld@mobile-5.com>
 */

class AclService {

    use ContainerTrait;

    public function getAcl()
    {
        return $this->getService('edweld_acl_service.acl');
    }

    public function isAllowed($action, $object)
    {
        switch($action)
        {
            case 'delete' :
                return $this->getService('edweld_acl_service.acl')->isAllowed($this->getUser(), Actions::DELETE, $object);
                break;
            case 'edit' :
                return $this->getService('edweld_acl_service.acl')->isAllowed($this->getUser(), Actions::EDIT, $object);
                break;
            case "view":
                var_dump('IS VIEW');
                return $this->getService('edweld_acl_service.acl')->isAllowed($this->getUser(), Actions::VIEW, $object);
                break;
        }
        
    }

    /**
     * Adds users from a specific circle to view an event
     */
    public function addAclCircleToEvent($event, $circle)
    {
        $users = $circle->getUsers();
        $owner = $this->getUser();

        $this->getService('edweld_acl_service.acl')->grant($owner, new EventEditorRole($owner, $event));

        foreach($users as $user){
        	$this->getService('edweld_acl_service.acl')->grant($user, new EventViewerRole($user, $event));
        }
    }
    
    /**
     * Adds new user to user view permissions of a circle
     * And adds user to all circle events
     */
    public function addAclUserToCircle($userObject, $circle)
    {
        $users = $circle->getUsers();

        foreach($users as $user){
            $this->getService('edweld_acl_service.acl')->grant($user, new UserViewerRole($user, $userObject));
            $this->getService('edweld_acl_service.acl')->grant($userObject, new UserViewerRole($userObject, $user));
        }
        foreach($circle->getEvents() as $event)
        {
            $this->getService('edweld_acl_service.acl')->grant($userObject, new EventViewerRole($userObject, $event));
        }
        $this->getService('edweld_acl_service.acl')->grant($userObject, new CircleViewerRole($userObject, $circle));

    }

    /*
     * Allow all user's circle users to view an event
     */

    public function addAclAllCirclesToEvent($event)
    {
        $owner = $this->getUser();
        $this->getService('edweld_acl_service.acl')->grant($owner, new EventEditorRole($owner, $event));

        foreach($owner->getCircles() as $circle)
        {
            foreach($circle->getUsers() as $user)
            {
                $this->getService('edweld_acl_service.acl')->grant($user, new EventViewerRole($user, $event));
            }
        }
    }
    /*
     * Allow a specific list of users to view an event
     */
    public function addAclUserArrayToEvent($event, $users){

        $owner = $this->getUser();
        $this->getService('edweld_acl_service.acl')->grant($user, new EventEditorRole($user, $event));

        foreach($users as $user)
        {
            $this->getService('edweld_acl_service.acl')->grant($user, new EventViewerRole($user, $event));
        }
    }

    public function removeUserFromCircle($user, $circle)
    {
        
    }

    public function removeCircle($circle)
    {
    	
    }
}
