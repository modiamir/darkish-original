<?php

namespace Darkish\CategoryBundle\EventListener;

use Darkish\CategoryBundle\Entity\Message;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\CategoryBundle\Entity\MessageThread;

class MessageThreadSubscriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
        );
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        $this->index($args);
        $this->setRecordInfoMessage($args);
    }


    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();


        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof MessageThread) {
        	$repo = $entityManager->getRepository('DarkishCategoryBundle:Message');
	        /* @var $qb \Doctrine\ORM\QueryBuilder */
	        $qb = $repo->createQueryBuilder('m');
	        $qb->where('m.thread = :thid')->setParameter('thid', $entity->getId());
	        $qb->orderBy('m.id', 'DESC');
	        $qb->setMaxResults(1);
	        $res = $qb->getQuery()->getResult();
	        
	        if(count($res)) {
	        	$entity->setLastMessage($res[0]);	
	        }
	        
        }
    }

    public function setRecordInfoMessage(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();


        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Message) {

            if($entity->getThread() && $entity->getThread()->getCustomer() && $entity->getThread()->getCustomer()->getRecord())
            {
                $entity->setRecordTitle($entity->getThread()->getCustomer()->getRecord()->getTitle());
                $entity->setRecordNumber($entity->getThread()->getCustomer()->getRecord()->getRecordNumber());
                $entity->setRecordId($entity->getThread()->getCustomer()->getRecord()->getId());
            }

        }
    }
}