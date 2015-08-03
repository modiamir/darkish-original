<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 8/2/15
 * Time: 5:50 PM
 */

namespace Darkish\CategoryBundle\EventListener;


use Darkish\CategoryBundle\Entity\Product;
use Darkish\CategoryBundle\Entity\Record;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;


class StoreSubscriber implements EventSubscriber
{

    private $things;

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            "preUpdate",
            "prePersist",
            "postFlush"
        ];
    }



    public function prePersist(LifecycleEventArgs $args) {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();
        if($entity instanceof Product) {
            $record = $entity->getRecord();
            $record->setMarketLastUpdate(new \DateTime());
            $this->things[] = $record;
        }
    }

    public function preUpdate($args) {
        $entity = $args->getEntity();
        if($entity instanceof Record) {
            if(count($args->getEntityChangeSet())) {
                $entityChangeSet = $args->getEntityChangeSet();
                $changeSet = array_keys($entityChangeSet);
                if(count(array_intersect(
                    $changeSet,[
                        'marketDescription',
                        'marketBanner',
                        'marketGroups',
                        'marketTemplate',
                        'marketOnlineOrder',
                    ]
                ))) {
                    $entity->setMarketLastUpdate(new \DateTime());
                }
            }
        }



        if($entity instanceof Product) {
            $record = $entity->getRecord();
            $record->setMarketLastUpdate(new \DateTime());
            $this->things[] = $record;
        }

    }





    public function postFlush($event)
    {
        if(!empty($this->things)) {

            $em = $event->getEntityManager();

            foreach ($this->things as $thing) {
                $em->persist($thing);
            }

            $this->things = [];
            $em->flush();
        }
    }

    public function postRemove($args) {
        $em = $args->getEntityManager();
        $entity = $args->getEntity();
        if($entity instanceof Product) {
            $record = $entity->getRecord();
            $record->setMarketLastUpdate(new \DateTime());
            $em->persist($record);
            $em->flush();
        }
    }

}