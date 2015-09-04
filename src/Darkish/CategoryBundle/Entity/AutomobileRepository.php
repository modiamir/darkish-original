<?php


namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Darkish\CategoryBundle\Entity\Automobile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class AutomobileRepository extends EntityRepository
{

    /**
     * @param Request $request
     * @return \Doctrine\ORM\Query
     */
    public function search(Automobile $automobile, $prices, Record $record = null)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->where('a.id > :validId')->setParameter('validId', 0);

        if($record) {
            $qb->andWhere('a.record = :recordId')->setParameter('recordId', $record->getId());
        }

        if($automobile->getAutomobileBrand())
        {
            $qb->andWhere('a.automobileBrand = :automobileBrand')
                ->setParameter('automobileBrand', $automobile->getAutomobileBrand()->getId());
        }

        if($automobile->getAutomobileType())
        {
            $qb->andWhere('a.automobileType = :automobileType')
                ->setParameter('automobileType', $automobile->getAutomobileType()->getId());
        }

        if($automobile->getAutomobileColor())
        {
            $qb->andWhere('a.automobileColor = :automobileColor')
                ->setParameter('automobileColor', $automobile->getAutomobileColor()->getId());
        }

        if($automobile->getCreatedYear())
        {
            $qb->andWhere('a.createdYear = :createdYear')
                ->setParameter('createdYear', $automobile->getCreatedYear());
        }

        if($automobile->getPrice())
        {
            $priceRange = explode(',', $automobile->getPrice());
            list($minPrice, $maxPrice) = $priceRange;

            $qb->andWhere('a.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);

            $qb->andWhere('a.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        if(isset($prices['from']))
        {
            $qb->andWhere('a.price >= :minPrice')
                ->setParameter('minPrice', $prices['from']);
        }

        if(isset($prices['to']))
        {
            $qb->andWhere('a.price <= :maxPrice')
                ->setParameter('maxPrice', $prices['to']);
        }

        return $qb->getQuery();

    }
}