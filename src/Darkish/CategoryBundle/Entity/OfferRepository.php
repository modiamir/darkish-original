<?php


namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Darkish\CategoryBundle\Entity\Offer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class OfferRepository extends EntityRepository
{
    public function getImagesFiles($entityId)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $repository = $this->getEntityManager()->getRepository('DarkishCategoryBundle:ManagedFile');



        //$offerList = $repository->findBy(array('status' => false));


        $queryBuilder = $repository->createQueryBuilder('m');
        /* @var $queryBuilder QueryBuilder */
        $queryBuilder->select('m.id, m.userId, m.fileName, m.path, m.filemime, m.filesize, m.status, m.timestamp, m.type, m.entityId, m.uploadDir')
        ->where('m.entityId = :eid and m.type = :offer')
        ->setParameter('eid', $entityId)
        ->setParameter('offer', 'offer');
        $query = $queryBuilder->getQuery();
        $offerList =  $query->getResult();
        $offerObjs = array();
        foreach($offerList as $offer) {
            $offerObj = $repository->find($offer['id']);
            $offerObjs[] = $offerObj;
        }
        return $serializer->serialize($offerObjs, 'json');

        if(!$offerList) {
            return false;
        } else {
            return $offerList;
        }




    }
}