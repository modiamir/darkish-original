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
    public function search(Automobile $automobile, Record $record = null)
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

        if($automobile->getCreatedYear())
        {
            $qb->andWhere('a.createdYear = :createdYear')
                ->setParameter('createdYear', $automobile->getCreatedYear());
        }

        if($automobile->getPrice())
        {
            $qb->andWhere('a.price >= :minPrice')
                ->setParameter('minPrice', (int)($automobile->getPrice() - 0.1 * $automobile->getPrice() ));

            $qb->andWhere('a.price <= :maxPrice')
                ->setParameter('maxPrice', (int)($automobile->getPrice() + 0.1 * $automobile->getPrice() ));
        }

        return $qb->getQuery();

    }
}