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
            if($entity instanceof MainTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:MainTree');
            } elseif($entity instanceof NewsTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:NewsTree');
            }
            elseif($entity instanceof OfferTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:OfferTree');
            }
            elseif($entity instanceof ClassifiedTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:ClassifiedTree');
            }
            elseif($entity instanceof ForumTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:ForumTree');
            }
            $treeIndex = $entity->getTreeIndex();
            $parentTreeIndex = substr($treeIndex, 0, 4);
            // die($parentTreeIndex);
            $parentTree = $repo->findByTreeIndex($parentTreeIndex)[0];
            $entity->setParentTreeTitle($parentTree->getTitle());
        }
        
        
    }

}