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
    private $commentManager;
    private $threadManager;

    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
        );
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        $this->index($args);
    }

    public function __construct(ContainerInterface $container) {
        $this->container = $container;
        // $this->commentManager = $this->container->get('fos_comment.manager.comment');
        // $this->threadManager = $this->container->get('fos_comment.manager.thread');
    }

    public function index(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Comment) {
            $parent = $entity->getParent();
            $parent->setReplyCount($parent->getReplyCount + 1);
            $entityManager->persist($parent);
            $entityManager->flush();
            
        }
    }
}