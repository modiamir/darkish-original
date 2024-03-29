<?php


namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Darkish\CategoryBundle\Entity\Estate;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\Request;

class EstateRepository extends EntityRepository
{
    /**
     * @param Request $request
     * @return \Doctrine\ORM\Query
     */
    public function search(Estate $estate, $prices, Record $record = null)
    {
        $qb = $this->createQueryBuilder('e');

        $qb->where('e.id > :validId')->setParameter('validId', 0);

        if($record) {
            $qb->andWhere('e.record = :recordId')->setParameter('recordId', $record->getId());
        }

        if($estate->getContractType())
        {
            $qb->andWhere('e.contractType = :contractType')
                ->setParameter('contractType', $estate->getContractType()->getId());
        }

        if($estate->getEstateType())
        {
            $qb->andWhere('e.estateType = :estateType')
                ->setParameter('estateType', $estate->getEstateType()->getId());
        }

        if($estate->getNumOfRooms())
        {
            $qb->andWhere('e.numOfRooms = :numOfRooms')
                ->setParameter('numOfRooms', $estate->getNumOfRooms());
        }

        if($estate->getDimension())
        {
            $qb->andWhere('e.dimension >= :minDimension')
                ->setParameter('minDimension', (int)($estate->getDimension() - 0.1 * $estate->getDimension() ));

            $qb->andWhere('e.dimension <= :maxDimension')
                ->setParameter('maxDimension', (int)($estate->getDimension() + 0.1 * $estate->getDimension() ));
        }

        if($estate->getPrice())
        {
            $priceRange = explode(',', $estate->getPrice());
            list($minPrice, $maxPrice) = $priceRange;


            $qb->andWhere('e.price >= :minPrice')
                ->setParameter('minPrice', $minPrice);

            $qb->andWhere('e.price <= :maxPrice')
                ->setParameter('maxPrice', $maxPrice);
        }

        if($estate->getContractType() && $estate->getContractType()->getId() == 2 && $estate->getSecondaryPrice())
        {
            $priceRange = explode(',', $estate->getSecondaryPrice());
            list($minSecondaryPrice, $maxSecondaryPrice) = $priceRange;


            $qb->andWhere('e.secondaryPrice >= :minSecondaryPrice')
                ->setParameter('minSecondaryPrice', $minSecondaryPrice);

            $qb->andWhere('e.secondaryPrice <= :maxSecondaryPrice')
                ->setParameter('maxSecondaryPrice', $maxSecondaryPrice);
        }

        if(isset($prices['from']))
        {
            $qb->andWhere('e.price >= :minPrice')
                ->setParameter('minPrice', $prices['from']);
        }

        if(isset($prices['to']))
        {
            $qb->andWhere('e.price <= :maxPrice')
                ->setParameter('maxPrice', $prices['to']);
        }

        return $qb->getQuery();

    }


}