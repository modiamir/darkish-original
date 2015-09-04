<?php

namespace Darkish\WebsiteBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Darkish\CategoryBundle\Entity\MainTree;

/**
 * MainTreeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class WebMainTreeRepository extends EntityRepository
{
    public function getTreeChildren(MainTree $tree) {
        
        /* @var $repo \Darkish\CategoryBundle\Entity\MainTree  */
        $qb = $this->createQueryBuilder('r');
        /* @var $qb QueryBuilder */
        $qb->where($qb->expr()->like('r.upTreeIndex', $qb->expr()->literal($tree->getTreeIndex() . '%')));
        return $qb->getQuery()->getResult();
    }


    public function getSubTrees($upTreeIndex = '00') {
        $qb = $this->createQueryBuilder('rt');
        $qb->where('rt.upTreeIndex = :upTreeIndex')->setParameter('upTreeIndex', $upTreeIndex);
        return $qb->getQuery()->getResult();   
    }
}