<?php

namespace Darkish\CategoryBundle\EventListener;


use Darkish\CategoryBundle\Entity\DBase;
use Darkish\CategoryBundle\Entity\Estate;
use Darkish\CategoryBundle\Entity\Product;
use Darkish\CategoryBundle\Entity\Record;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\DependencyInjection\Container;


class DBaseSubscriber implements EventSubscriber
{

    private $things;
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Returns an array of events this subscriber wants to listen to.
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            "postLoad",
            "postPersist",
            "postUpdate",
            "postRemove",
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

    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if($entity instanceof DBase)
        {
            $this->updateRangeSliderBoundries($args);
        }
    }


    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if($entity instanceof DBase)
        {
            $this->updateRangeSliderBoundries($args);
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        if($entity instanceof DBase)
        {
            $this->updateRangeSliderBoundries($args);
        }
    }

    private function updateRangeSliderBoundries(LifecycleEventArgs $args)
    {
        $em = $args->getEntityManager();
        $estateQB= $em->getRepository('DarkishCategoryBundle:Estate')->createQueryBuilder('es');
        $automobileQB = $em->getRepository('DarkishCategoryBundle:Automobile')->createQueryBuilder('au');

        $boundries = [];

        $estateMinSellPrice = $estateQB
            ->select('min(es.price)')
            ->where('es.contractType != :cid')
            ->setParameter('cid', 2)
            ->getQuery()->getSingleScalarResult()
        ;

        $estateMaxSellPrice = $estateQB
            ->select('max(es.price)')
            ->where('es.contractType != :cid')
            ->setParameter('cid', 2)
            ->getQuery()->getSingleScalarResult()
        ;

        $boundries['estate_sell_price'] = [
            'min' => $estateMinSellPrice,
            'max' => $estateMaxSellPrice,
        ];

        $estateMaxRentPrice = $estateQB
            ->select('max(es.price)')
            ->where('es.contractType = :cid')
            ->setParameter('cid', 2)
            ->getQuery()->getSingleScalarResult()
        ;

        $estateMinRentPrice = $estateQB
            ->select('min(es.price)')
            ->where('es.contractType = :cid')
            ->setParameter('cid', 2)
            ->getQuery()->getSingleScalarResult()
        ;

        $boundries['estate_rent_price'] = [
            'min' => $estateMinRentPrice,
            'max' => $estateMaxRentPrice,
        ];


        $estateMaxRentSecondaryPrice = $estateQB
            ->select('max(es.price)')
            ->where('es.contractType = :cid')
            ->setParameter('cid', 2)
            ->getQuery()->getSingleScalarResult()
        ;

        $estateMinRentSecondaryPrice = $estateQB
            ->select('min(es.price)')
            ->where('es.contractType = :cid')
            ->setParameter('cid', 2)
            ->getQuery()->getSingleScalarResult()
        ;

        $boundries['estate_rent_secondary_price'] = [
            'min' => $estateMinRentSecondaryPrice,
            'max' => $estateMaxRentSecondaryPrice,
        ];

        $automobileMaxPrice = $automobileQB
            ->select('max(au.price)')
            ->getQuery()->getSingleScalarResult()
        ;

        $automobileMinPrice = $automobileQB
            ->select('min(au.price)')
            ->getQuery()->getSingleScalarResult()
        ;

        $boundries['automobile_price'] = [
            'min' => $automobileMinPrice,
            'max' => $automobileMaxPrice,
        ];



        file_put_contents('/home/shahed/www/web/dbase_range_slider_boundries.json',
            $this->container->get('jms_serializer')->serialize($boundries, 'json')
        );







    }

}