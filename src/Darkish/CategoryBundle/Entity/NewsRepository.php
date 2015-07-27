<?php


namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Darkish\CategoryBundle\Entity\News;
use Darkish\CategoryBundle\Entity\NewsTree;
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

    public function getNewsForCat(NewsTree $tree) {
        $newsTreeRepo = $this->getEntityManager()->getRepository('DarkishCategoryBundle:NewsTree');

        $children = $newsTreeRepo->getTreeChildren($tree);

        $treesIds = array();
        $treesIds[] = $tree->getId();
        foreach($children as $child) {
            $treesIds[] = $child->getId();
        }

        $newsQuery = $this->createQueryBuilder('n');
        $newsQuery->join('n.newstrees', 'nt');
        $newsQuery->join('nt.tree','t', 'WITH',$newsQuery->expr()->in('t.id', $treesIds))->distinct();
        $newsQuery->orderBy('n.lastUpdate', 'Desc');
        // $newsQuery->addOrderBy('nt.sort', 'Asc');

        return $newsQuery;
    }

}