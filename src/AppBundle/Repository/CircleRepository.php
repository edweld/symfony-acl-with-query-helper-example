<?php

namespace AppBundle\Repository;

use Edweld\AclBundle\Doctrine\ACLQueryHelper;
use Doctrine\ORM\EntityRepository;
use Edweld\AclBundle\Entity\Actions;

/**
 * CircleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CircleRepository extends \Doctrine\ORM\EntityRepository
{
	public function findAllWithAcl($user)
    {
        $qb = $this->createQueryBuilder('circle');
        ACLQueryHelper::joinACL($qb, $user, Actions::VIEW);
        $q = $qb->getQuery();
        return $q->getResult();
    }

    public function searchAclQuery($user, $term)
    {
    	$qb = $this->createQueryBuilder();
    	$qb
    	    ->select('c')
    	    ->from('AppBundle:Circle c')
    	    ->where('name LIKE :term')
    	    ->setParameter('term', '%'.$term.'%');

    	    ACLQueryHelper::joinACL($qb, $user, Actions::VIEW);
    	    return $qb;
    }
}
