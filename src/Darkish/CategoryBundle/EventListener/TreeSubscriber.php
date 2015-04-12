<?php
namespace Darkish\CategoryBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\CategoryBundle\Entity\MainTree;
use Darkish\CategoryBundle\Entity\NewsTree;
use Darkish\CategoryBundle\Entity\OfferTree;
use Darkish\CategoryBundle\Entity\ClassifiedTree;
use Darkish\CategoryBundle\Entity\ForumTree;

class TreeSubscriber implements EventSubscriber
{
    protected $entityManager;
    
    public function getSubscribedEvents()
    {
        return array(
            'postLoad',
        );
    }

    public function postLoad(LifecycleEventArgs $args)
    {
        
        $entity = $args->getEntity();
        
//        /* @var $entity MainTree */
//        $test = $repo->find();
        
        if( $entity instanceof MainTree || $entity instanceof NewsTree || $entity instanceof OfferTree || $entity instanceof ClassifiedTree|| $entity instanceof ForumTree) {
            // die('asd');
            $treeIndex = $entity->getTreeIndex();
            $parentTreeIndex = substr($treeIndex, 0, 4);
            if($entity instanceof MainTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:MainTree');
                $parentTree = $repo->findByTreeIndex($parentTreeIndex)[0];
                $entity->setParentTreeTitle($parentTree->getTitle());
            } elseif($entity instanceof NewsTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:NewsTree');
                // $parentTreeIndex = substr($treeIndex, 0, strlen($treeIndex) - 2);
                // $parentTree = $repo->findByTreeIndex($parentTreeIndex)[0];
                $parents = array();
                $parentTreeIndex = substr($treeIndex, 0, strlen($treeIndex) - 2);
                while($parentTreeIndex != '00') {
                    $parents[] = $parentTreeIndex;
                    $parentTreeIndex = substr($parentTreeIndex, 0, strlen($parentTreeIndex) - 2);
                }

                $query = $args->getEntityManager()->createQuery('SELECT nt FROM \Darkish\CategoryBundle\Entity\NewsTree nt WHERE nt.treeIndex IN (:tindexes)');
                $query->setParameter('tindexes', $parents);
                $trees = $query->getResult();

                $parents = array();
                foreach ($trees as $key => $value) {
                    $parents[] = $value->getTitle();
                }

                $entity->setParentTreeTitle(implode('-->', $parents));
            }
            elseif($entity instanceof OfferTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:OfferTree');
                $parentTree = $repo->findByTreeIndex($parentTreeIndex)[0];
                $entity->setParentTreeTitle($parentTree->getTitle());
            }
            elseif($entity instanceof ClassifiedTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:ClassifiedTree');
                $parentTree = $repo->findByTreeIndex($parentTreeIndex)[0];
                $entity->setParentTreeTitle($parentTree->getTitle());
            }
            elseif($entity instanceof ForumTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:ForumTree');
                $parentTree = $repo->findByTreeIndex($parentTreeIndex)[0];
                $entity->setParentTreeTitle($parentTree->getTitle());
            }
            
            
            // die($parentTreeIndex);
            
            
        }
        
        
    }

}