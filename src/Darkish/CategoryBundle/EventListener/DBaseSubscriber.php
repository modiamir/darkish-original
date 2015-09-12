<?php

namespace Darkish\CategoryBundle\EventListener;


use Darkish\CategoryBundle\Entity\DBase;
use Darkish\CategoryBundle\Entity\Estate;
use Darkish\CategoryBundle\Entity\Product;
use Darkish\CategoryBundle\Entity\Record;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\QueryBuilder;
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

        $oldBoundries = file_get_contents('/home/shahed/www/web/dbase_range_slider_boundries.json');

        $arrayBoundries = $this->container->get('jms_serializer')->deserialize($oldBoundries, 'array', 'json');

        $date = new \DateTime($arrayBoundries['date']);
        $now = new \DateTime();

        if( (int)(($now->getTimestamp() - $date->getTimestamp()) / (60)) <= 60)
        {
            return;
        }

        $boundries = $this->generatePrices($estateQB, $automobileQB);


        file_put_contents('/home/shahed/www/web/dbase_range_slider_boundries.json',
            $this->container->get('jms_serializer')->serialize($boundries, 'json')
        );


    }


    private function generatePrices(QueryBuilder $estateQB, QueryBuilder $automobileQB) {
        $estateTypes = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:EstateType')
            ->findAll();

        $rentPrices = [];
        $sellPrices = [];

        foreach($estateTypes as $estateType)
        {

            $estateMinRentPrice = $estateQB
                ->select('min(es.price)')
                ->where('es.contractType = :cid')
                ->setParameter('cid', 2)
                ->andWhere('es.estateType = :etid')
                ->setParameter('etid', $estateType->getId())
                ->getQuery()->getSingleScalarResult()
            ;

            $estateMaxRentPrice = $estateQB
                ->select('max(es.price)')
                ->where('es.contractType = :cid')
                ->setParameter('cid', 2)
                ->andWhere('es.estateType = :etid')
                ->setParameter('etid', $estateType->getId())
                ->getQuery()->getSingleScalarResult()
            ;

            $estateMinRentSecondaryPrice = $estateQB
                ->select('min(es.secondaryPrice)')
                ->where('es.contractType = :cid')
                ->setParameter('cid', 2)
                ->andWhere('es.estateType = :etid')
                ->setParameter('etid', $estateType->getId())
                ->getQuery()->getSingleScalarResult()
            ;

            $estateMaxRentSecondaryPrice = $estateQB
                ->select('max(es.secondaryPrice)')
                ->where('es.contractType = :cid')
                ->setParameter('cid', 2)
                ->andWhere('es.estateType = :etid')
                ->setParameter('etid', $estateType->getId())
                ->getQuery()->getSingleScalarResult()
            ;

            $estateMinSellPrice = $estateQB
                ->select('min(es.price)')
                ->where('es.contractType != :cid')
                ->setParameter('cid', 2)
                ->andWhere('es.estateType = :etid')
                ->setParameter('etid', $estateType->getId())
                ->getQuery()->getSingleScalarResult()
            ;

            $estateMaxSellPrice = $estateQB
                ->select('max(es.price)')
                ->where('es.contractType != :cid')
                ->setParameter('cid', 2)
                ->andWhere('es.estateType = :etid')
                ->setParameter('etid', $estateType->getId())
                ->getQuery()->getSingleScalarResult()
            ;

            $rentPrices[$estateType->getId()] = [
                'price' => [
                    'min' => $estateMinRentPrice,
                    'max' => $estateMaxRentPrice
                ],
                'secondaryPrice' => [
                    'min' => $estateMinRentSecondaryPrice,
                    'max' => $estateMaxRentSecondaryPrice
                ]
            ];

            $sellPrices[$estateType->getId()] = [
                'price' => [
                    'min' => $estateMinSellPrice,
                    'max' => $estateMaxSellPrice
                ]
            ];

        }


        $automobileMaxPrice = $automobileQB
            ->select('max(au.price)')
            ->getQuery()->getSingleScalarResult()
        ;

        $automobileMinPrice = $automobileQB
            ->select('min(au.price)')
            ->getQuery()->getSingleScalarResult()
        ;

        $automobilePrices = [
            'min' => $automobileMinPrice,
            'max' => $automobileMaxPrice,
        ];

        $boundries = [];
        $boundries['estate_rent'] = $rentPrices;
        $boundries['estate_sell'] = $sellPrices;
        $boundries['automobile'] = $automobilePrices;
        $boundries['date'] = new \DateTime();

        return $boundries;
    }

}