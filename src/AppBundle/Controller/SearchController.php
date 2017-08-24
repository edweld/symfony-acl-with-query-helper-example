<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\User;
use AppBundle\Entity\Event;
use AppBundle\Entity\Circle;

/**
 * Search controller.
 *
 * @Route("/search")
 */

class SearchController extends Controller {
    
     /**
      * @Route("/circles/{term}")
      * @Method({"POST","GET"})
      */
     public function circlesAction( $term )
     {
     	//sanitise $term
     	    $qb = $this->getDoctrine()->getRepository('AppBundle:Circle')->searchAclQuery( $this->getUser(), $term);
     	    return new JsonResponse($qb->getQuery()->getResult());
     }

     /**
      * @Route("/events/{term}")
      * @Method({"POST","GET"})
      */
     public function eventsAction( $term )
     {
     	$qb = $this->getDoctrine()->getRepository('AppBundle:Event')->searchAclQuery( $this->getUser(), $term);
     	return new JsonResponse($qb->getQuery()->getResult());
     	//sanitise $term

     }

     /**
      * @Route("/users/{term}")
      * @Method({"POST","GET"})
      */
     public function usersAction( $term )
     {
     	//sanitise $term
        $qb = $this->getDoctrine()->getRepository('AppBundle:Event')->searchAclQuery( $this->getUser(), $term);
     	return new JsonResponse($qb->getQuery()->getResult());
     }


}