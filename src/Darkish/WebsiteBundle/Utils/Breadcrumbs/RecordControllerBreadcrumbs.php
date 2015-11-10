<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/19/15
 * Time: 5:50 PM
 */

namespace Darkish\WebsiteBundle\Utils\Breadcrumbs;


use Darkish\CategoryBundle\Entity\Record;
use Darkish\WebsiteBundle\Entity\WebMainTree;


class RecordControllerBreadcrumbs extends AbstractControllerBreadcrumbs
{

    public function websiteRecordSingleBuilder(Record $record) {

        $this->bread->prependItem($record->getTitle());

        $doctrine = $this->container->get('doctrine');

        $recordTrees = $record->getMaintrees();


        /* @var $recordTreesIterator \ArrayIterator */
        $recordTreesIterator = $recordTrees->getIterator();

        $recordTreesIds = [];

        if($this->container->get('request')->query->has('source_tree')) {
            $webMainTree = $doctrine->getRepository('DarkishWebsiteBundle:WebMainTree')
                ->findOneBy(['treeIndex' => $this->container->get('request')->query->get('source_tree')]);
        } else {
            while($recordTreesIterator->valid())
            {
                $recordTreesIds[] = $recordTreesIterator->current()->getTree()->getTreeIndex();
                $recordTreesIterator->next();
            }

            $webMainTrees = $doctrine->getRepository('DarkishWebsiteBundle:WebMainTree')
                ->createQueryBuilder('web_main_tree')
                ->where('web_main_tree.referenceTreeIndex in (:treesIds)')->setParameter('treesIds', $recordTreesIds)
                ->getQuery()
                ->getResult()
            ;

            if(count($webMainTrees))
            {
                /* @var $webMainTree WebMainTree */
                $webMainTree = $webMainTrees[0];
            }
        }




        if(isset($webMainTree))
        {
            $webMainTreeIndex = $webMainTree->getTreeIndex();
            $hierarchy = [];
            while($webMainTreeIndex != "")
            {
                $hierarchy[] = $webMainTreeIndex;
                $webMainTreeIndex = substr($webMainTreeIndex, 0, strlen($webMainTreeIndex) - 2);
            }

            $webMainTrees = $doctrine->getRepository('DarkishWebsiteBundle:WebMainTree')
                ->createQueryBuilder('web_main_tree')
                ->where('web_main_tree.treeIndex in (:treesIds)')->setParameter('treesIds', $hierarchy)
                ->orderBy('web_main_tree.treeIndex', 'desc')
                ->getQuery()
                ->getResult();

            foreach($webMainTrees as $webMainTree)
            {
                $this->bread->prependItem(
                    $webMainTree->getTitle(),
                    $this->router->generate('website_record_tree', ['treeIndex' => $webMainTree->getTreeIndex()])
                );
            }
        }


        $this->bread->prependItem('مشاغل', $this->router->generate('website_record'));

        $this->bread->prependItem('خانه', $this->router->generate('website_home'));

    }
}