<?php

namespace Darkish\CategoryBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\CategoryBundle\Entity\Record;
use Darkish\CategoryBundle\Entity\DeletedRecords;
use Darkish\CategoryBundle\Entity\News;
use Darkish\CategoryBundle\Entity\Offer;
use Darkish\CategoryBundle\Entity\Classified;
use Proxies\__CG__\Darkish\CategoryBundle\Entity\RecordAccessLevel;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use Alchemy\BinaryDriver\Listeners\DebugListener;
use Symfony\Component\HttpFoundation\File\File;
use JMS\Serializer\SerializationContext;
use Doctrine\ORM\Event\PreUpdateEventArgs;



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
            'postUpdate',
        );
    }


    public function prePersist(LifecycleEventArgs $args)
    {
        $this->setHasMedias($args);
        // $this->updateTreeJson($args);
    }

    


    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof News ) {

            $changes = $args->getEntityChangeSet();
            if(isset($changes['publishDate'])) {
                $publishDateChange = $changes['publishDate'];
                unset($changes['publishDate']);
                if($publishDateChange[0] != $publishDateChange[1] || count($changes) > 0) {
                    $entity->setLastUpdate(new \DateTime());
                }
            }
            if(isset($changes['body'])) {
                unset($changes['body']);
                $entity->setHtmlLastUpdate(new \DateTime());
            }




        }

        if ($entity instanceof Record ) {

            $changes = $args->getEntityChangeSet();
            if(isset($changes['body'])) {
                unset($changes['body']);
                $entity->setHtmlLastUpdate(new \DateTime());
            }



            if(count($changes) > 0) {
                $entity->setLastUpdate(new \DateTime());
            }
        }


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

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        if($entity instanceof Record)
        {
            $record = $entity;

            $query2 = $entityManager->createQuery("
                Update Darkish\CustomerBundle\Entity\Customer customer Set customer.recordAccessLevel = :recordAccessLevel Where customer.record = :rid
                ");
            $query2->setParameter('recordAccessLevel',$record->getAccessClass()->getId());
            $query2->setParameter('rid', $record->getId());
            $query2->execute();

            if($record->getExpireDate() instanceof \DateTime)
            {
                $query = $entityManager->createQuery("
                Update Darkish\CustomerBundle\Entity\Customer customer Set customer.expireDate = :expdate Where customer.record = :rid
                ");
                $query->setParameter('expdate',$record->getExpireDate());
                $query->setParameter('rid', $record->getId());
                $query->execute();
            }


        }
    }


    // private function updateTreeJson(LifecycleEventArgs $args) {
    //     $entity = $args->getEntity();
    //     $entityManager = $args->getEntityManager();
    //     if($entity instanceof News) {
    //         $trees = $entity->getNewstrees();
    //         die($this->container->get('jms_serializer')->serialize($entity, 'json', SerializationContext::create()->setGroups(array('news.details'))));

    //     }
    // }
}
