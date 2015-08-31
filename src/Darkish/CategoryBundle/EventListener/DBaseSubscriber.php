<?php

namespace Darkish\CategoryBundle\EventListener;


use Darkish\CategoryBundle\Entity\Estate;
use Darkish\CategoryBundle\Entity\Product;
use Darkish\CategoryBundle\Entity\Record;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;


class DBaseSubscriber implements EventSubscriber
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
            "postLoad",
        ];
    }



    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if($entity instanceof Estate)
        {
            $qb = $entityManager->getRepository('DarkishCategoryBundle:EstateFeatures')
                    ->createQueryBuilder('ef');
            $qb->where('ef.id in (:estateFeatures)')->setParameter('estateFeatures', $entity->getEstateFeatures());

            $entity->setEstateFeaturesCollection($qb->getQuery()->getResult());
        }
    }

}