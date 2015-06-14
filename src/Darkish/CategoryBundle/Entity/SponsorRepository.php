<?php


namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Darkish\CategoryBundle\Entity\Sponsor;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class SponsorRepository extends EntityRepository
{
    public function getImagesFiles($entityId)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $repository = $this->getEntityManager()->getRepository('DarkishCategoryBundle:ManagedFile');



        //$sponsorList = $repository->findBy(array('status' => false));


        $queryBuilder = $repository->createQueryBuilder('m');
        /* @var $queryBuilder QueryBuilder */
        $queryBuilder->select('m.id, m.userId, m.fileName, m.path, m.filemime, m.filesize, m.status, m.timestamp, m.type, m.entityId, m.uploadDir')
        ->where('m.entityId = :eid and m.type = :sponsor')
        ->setParameter('eid', $entityId)
        ->setParameter('sponsor', 'sponsor');
        $query = $queryBuilder->getQuery();
        $sponsorList =  $query->getResult();
        $sponsorObjs = array();
        foreach($sponsorList as $sponsor) {
            $sponsorObj = $repository->find($sponsor['id']);
            $sponsorObjs[] = $sponsorObj;
        }
        return $serializer->serialize($sponsorObjs, 'json');

        if(!$sponsorList) {
            return false;
        } else {
            return $sponsorList;
        }




    }
}