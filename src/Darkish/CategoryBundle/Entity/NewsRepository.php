<?php


namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Darkish\CategoryBundle\Entity\News;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class NewsRepository extends EntityRepository
{
    public function getImagesFiles($entityId)
    {
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $repository = $this->getEntityManager()->getRepository('DarkishCategoryBundle:ManagedFile');



        //$newsList = $repository->findBy(array('status' => false));


        $queryBuilder = $repository->createQueryBuilder('m');
        /* @var $queryBuilder QueryBuilder */
        $queryBuilder->select('m.id, m.userId, m.fileName, m.path, m.filemime, m.filesize, m.status, m.timestamp, m.type, m.entityId, m.uploadDir')
        ->where('m.entityId = :eid and m.type = :news')
        ->setParameter('eid', $entityId)
        ->setParameter('news', 'news');
        $query = $queryBuilder->getQuery();
        $newsList =  $query->getResult();
        $newsObjs = array();
        foreach($newsList as $news) {
            $newsObj = $repository->find($news['id']);
            $newsObjs[] = $newsObj;
        }
        return $serializer->serialize($newsObjs, 'json');

        if(!$newsList) {
            return false;
        } else {
            return $newsList;
        }




    }
}