<?php

// src/Acme/SearchBundle/EventListener/SearchIndexerSubscriber.php
namespace Darkish\CommentBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\CommentBundle\Entity\Comment;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JMS\Serializer\SerializationContext;

class CommentSubscriber implements EventSubscriber
{
    private $container;

    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'prePersist',
            'postLoad',
        );
    }

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Comment) {
            //set created time before saving to database
            $entity->setCreatedAt(new \DateTime());
            if( !($user instanceof \Darkish\UserBundle\Entity\Operator) ) {
                $entity->setUnseenByOperators(true);
            }
            if( !($user instanceof \Darkish\CustomerBundle\Entity\Customer) ) {
                $entity->setUnseenByCustomers(true);
            }
        }
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        $user = $this->container->get('security.context')->getToken()->getUser();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Comment) {
            $parent = $entity->getParent();
            if($parent instanceof Comment) {
                $parent->setReplyCount($parent->getReplyCount() + 1);
                if( !($user instanceof \Darkish\UserBundle\Entity\Operator) ) {
                    $parent->setUnseenRepliesByOperators($parent->getUnseenRepliesByOperators() + 1);
                }
                if( !($user instanceof \Darkish\CustomerBundle\Entity\Customer) ) {
                    $parent->setUnseenRepliesByCustomers($parent->getUnseenRepliesByCustomers() + 1);
                }
                $entityManager->persist($parent);
                $entityManager->flush();
            }
            
            
        }
    }

    public function postLoad(LifecycleEventArgs $args) {
        
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Comment) {
            $this->setHasLiked($args);
            
            
        }
    }

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        // $this->commentManager = $this->container->get('fos_comment.manager.comment');
        // $this->threadManager = $this->container->get('fos_comment.manager.thread');
    }

    private function setHasLiked(LifecycleEventArgs $args) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        $userType = null;
        if($user instanceof \Darkish\UserBundle\Entity\Client) {
            $userType = 'client';
        } elseif($user instanceof \Darkish\UserBundle\Entity\Operator) {
            $userType = 'operator';
        } elseif($user instanceof \Darkish\CustomerBundle\Entity\Customer) {
            $userType = 'customer';
        } else {
            $userType = null;
            $entity->setHasLiked(false);
            return;
        }




        $repo = $entityManager->getRepository('DarkishCategoryBundle:CommentLike');
        $qb = $repo->createQueryBuilder('cl');
        
        $qb->where("cl.userType = :userType")->andWhere('cl.userId = :userId')->andWhere('cl.target = :cid');
        


        $qb->setParameter('userType', $userType);
        $qb->setParameter('userId', $user->getId());
        $qb->setParameter('cid', $entity->getId());
        
        $result = $qb->getQuery()->getResult();
        $entity->setHasLiked(count($result) > 0);

    }


}