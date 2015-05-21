<?php

namespace Darkish\CategoryBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\CategoryBundle\Entity\Record;
use Darkish\CategoryBundle\Entity\News;
use Darkish\CategoryBundle\Entity\Offer;
use Darkish\CategoryBundle\Entity\Classified;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use Alchemy\BinaryDriver\Listeners\DebugListener;
use Symfony\Component\HttpFoundation\File\File;




class CnorSubscriber implements EventSubscriber
{
    protected $container;
    protected $requestStack;
    
    public function __construct(ContainerInterface $container, RequestStack $requestStack) {
        $this->container = $container;
        $this->requestStack = $requestStack;
    }


    public function getSubscribedEvents()
    {
        return array(
            'prePersist',
            'preUpdate',
        );
    }


    public function prePersist(LifecycleEventArgs $args)
    {
        $this->setHasMedias($args);
        
    }
    
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->setHasMedias($args);
        
    }
    
    public function setHasMedias(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Record || 
            $entity instanceof News || 
            $entity instanceof Offer || 
            $entity instanceof Classified ) {

            if($entity->getVideos()->count()) {
                $entity->setVideo(true);
            } else {
                $entity->setVideo(false);
            }

            if($entity->getAudios()->count()) {
                $entity->setAudio(true);
            } else {
                $entity->setAudio(false);
            }
                     
        }  
    }


}