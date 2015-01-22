<?php
namespace Darkish\CategoryBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\CategoryBundle\Entity\MainTree;
use Darkish\CategoryBundle\Entity\NewsTree;

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
        
        if( $entity instanceof MainTree || $entity instanceof NewsTree) {
//            die('asd');
            if($entity instanceof MainTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:MainTree');
            } elseif($entity instanceof NewsTree) {
                $repo = $args->getEntityManager()->getRepository('DarkishCategoryBundle:NewsTree');
            }
            $treeIndex = $entity->getTreeIndex();
            $parentTreeIndex = substr($treeIndex, 0, 4);
//            die($parentTreeIndex);
            $parentTree = $repo->findByTreeIndex($parentTreeIndex)[0];
            $entity->setParentTreeTitle($parentTree->getTitle());
        }
        
        
    }

}