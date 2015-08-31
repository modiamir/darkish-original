<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 8/9/15
 * Time: 2:17 PM
 */

namespace Darkish\CommentBundle\Entity;


use Doctrine\ORM\EntityRepository;

class CommentRepository extends EntityRepository
{
    public function getChildren(Comment $comment, $lastId = null) {
        $qb = $this->createQueryBuilder('c');

        $qb->where('c.parent = :pid')->setParameter('pid', $comment->getId());
        if($lastId) {
            $qb->andWhere('c.id < :lastId')->setParameter('lastId', $lastId);
        }
        $qb->orderBy('c.createdAt', 'Desc');

        $qb->setMaxResults(5);
        $children = $qb->getQuery()->getResult();

        return $children;
    }

    public function getChildrenCount(Comment $comment) {

    }
}