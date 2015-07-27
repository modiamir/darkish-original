<?php


namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Darkish\CategoryBundle\Entity\NewsTree;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class NewsTreeRepository extends EntityRepository
{
    
    public function getTreeChildren(NewsTree $tree) {
        
        /* @var $repo \Darkish\CategoryBundle\Entity\MainTree  */
        $qb = $this->createQueryBuilder('r');
        /* @var $qb QueryBuilder */
        $qb->where($qb->expr()->like('r.upTreeIndex', $qb->expr()->literal($tree->getTreeIndex() . '%')));
        return $qb->getQuery()->getResult();
    }


    public function getSubTrees($upTreeIndex = '##') {
        $qb = $this->createQueryBuilder('nt');
        $qb->where('nt.upTreeIndex = :upTreeIndex')->setParameter('upTreeIndex', $upTreeIndex);
        return $qb->getQuery()->getResult();   
    }
}