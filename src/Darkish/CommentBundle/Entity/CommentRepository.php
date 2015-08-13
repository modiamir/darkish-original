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
    public function getChildren(Comment $comment) {
        $children = $this->findBy(['parent' => $comment->getId()], ['createdAt' => 'Desc'], 10);
        return $children;
    }

    public function getChildrenCount(Comment $comment) {

    }
}