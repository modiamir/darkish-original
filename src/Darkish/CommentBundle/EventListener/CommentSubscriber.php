<?php

// src/Acme/SearchBundle/EventListener/SearchIndexerSubscriber.php
namespace Darkish\CommentBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
// for Doctrine 2.4: Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Darkish\CommentBundle\Entity\Comment;
use Darkish\CommentBundle\Entity\Thread;
use Darkish\CommentBundle\Entity\RecordThread;
use Darkish\CommentBundle\Entity\NewsThread;
use Darkish\CommentBundle\Entity\ForumTreeThread;
use Darkish\CommentBundle\Entity\SafarsazThread;
use Symfony\Component\DependencyInjection\ContainerInterface;
use JMS\Serializer\SerializationContext;

class CommentSubscriber implements EventSubscriber
{
    private $container;
    private $commentSettings;

    public function getSubscribedEvents()
    {
        return array(
            'postPersist',
            'prePersist',
            'postLoad',
        );
    }

    public function prePersist(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        
        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Comment) {
            //set created time before saving to database
            $user = $this->container->get('security.context')->getToken()->getUser();
            $entity->setCreatedAt(new \DateTime());
            $this->setUnseen($args);
            $this->setStates($args);
        }
        
    }



    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Comment) {
            $user = $this->container->get('security.context')->getToken()->getUser();
            $this->setUnseenReplies($args);
            $thread = $entity->getThread();
            
            if($thread instanceof RecordThread) {

                $this->increamentRecordCommentCount($args);
            }
        }
    }

    public function postLoad(LifecycleEventArgs $args) {
        
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        // perhaps you only want to act on some "Product" entity
        if ($entity instanceof Comment) {
            $this->setHasLiked($args);


            
        }
    }

    public function __construct(ContainerInterface $container, $commentSettings) {
        $this->container = $container;
        $this->commentSettings = $commentSettings;
        // $this->commentManager = $this->container->get('fos_comment.manager.comment');
        // $this->threadManager = $this->container->get('fos_comment.manager.thread');
    }

    private function setHasLiked(LifecycleEventArgs $args) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        $userType = null;
        if($user instanceof \Darkish\UserBundle\Entity\Client) {
            $userType = 'client';
        } elseif($user instanceof \Darkish\UserBundle\Entity\Operator) {
            $userType = 'operator';
        } elseif($user instanceof \Darkish\CustomerBundle\Entity\Customer) {
            $userType = 'customer';
        } else {
            $userType = null;
            $entity->setHasLiked(false);
            return;
        }




        $repo = $entityManager->getRepository('DarkishCategoryBundle:CommentLike');
        $qb = $repo->createQueryBuilder('cl');
        
        $qb->where("cl.userType = :userType")->andWhere('cl.userId = :userId')->andWhere('cl.target = :cid');
        


        $qb->setParameter('userType', $userType);
        $qb->setParameter('userId', $user->getId());
        $qb->setParameter('cid', $entity->getId());
        
        $result = $qb->getQuery()->getResult();
        $entity->setHasLiked(count($result) > 0);

    }

    private function increamentRecordCommentCount(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        $thread = $entity->getThread();

        $record = $thread->getTarget();

        $record->setCommentCount($record->getCommentCount() + 1);
        $entityManager->persist($record);
        $entityManager->flush();
    }


    private function setUnseen(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        
        if( !($user instanceof \Darkish\UserBundle\Entity\Operator) ) {
            $entity->setUnseenByOperators(true);
        }
        if( !($user instanceof \Darkish\CustomerBundle\Entity\Customer) ) {
            $entity->setUnseenByCustomers(true);
        }
    }

    private function setUnseenReplies(LifecycleEventArgs $args) {
        $entity = $args->getEntity();
        $entityManager = $args->getEntityManager();

        $user = $this->container->get('security.context')->getToken()->getUser();

        $parent = $entity->getParent();
        if($parent instanceof Comment) {
            $parent->setReplyCount($parent->getReplyCount() + 1);
            if( !($user instanceof \Darkish\UserBundle\Entity\Operator) ) {
                $parent->setUnseenRepliesByOperators($parent->getUnseenRepliesByOperators() + 1);
            }
            if( !($user instanceof \Darkish\CustomerBundle\Entity\Customer) ) {
                $parent->setUnseenRepliesByCustomers($parent->getUnseenRepliesByCustomers() + 1);
            }
            $entityManager->persist($parent);
            $entityManager->flush();
        }

    }


    public function setStates(LifecycleEventArgs $args) {
        $user = $this->container->get('security.context')->getToken()->getUser();
        $entity = $args->getEntity();
        $owner = $entity->getOwner();
        $entityManager = $args->getEntityManager();
        if($owner instanceof \Darkish\UserBundle\Entity\Operator || $owner instanceof \Darkish\CustomerBundle\Entity\Customer) {
            $entity->setState(0);
        } elseif($owner instanceof \Darkish\UserBundle\Entity\Client) {
            $thread = $entity->getThread();
            if($thread instanceof SafarsazThread) {
                if($this->commentSettings['safarsaz_default_state'] == 1) {
                    $entity->setState(0);
                } else {
                    $entity->setState(3);
                }
            } elseif($thread instanceof ForumTreeThread){
                if($this->commentSettings['forum_default_state'] == 1) {
                    $entity->setState(0);
                } else {
                    $entity->setState(3);
                }
            } elseif($thread instanceof NewsThread) {
                if($this->commentSettings['news_default_state'] == 1) {
                    $entity->setState(0);
                } elseif($this->commentSettings['news_default_state'] == 2) {
                    $dangerousTrees = $this->commentSettings['news_dangerous_trees'];
                    $trees = $thread->getTarget()->getNewstrees();
                    $treesIterator = $trees->getIterator();
                    $dangerous = false;
                    while($treesIterator->valid()) {
                        $currentTree = $treesIterator->current()->getTree();
                        if($this->isDangerous($currentTree->getTreeIndex(), $dangerousTrees)) {
                            $dangerous = true;
                            break;
                        }
                        $treesIterator->next();
                    }
                    if($dangerous) {
                        $entity->setState(3);
                    } else {
                        $entity->setState(0);
                    }

                } else {
                    $entity->setState(3);
                }

            } elseif($thread instanceof RecordThread) {
                if($this->commentSettings['record_default_state'] == 1) {
                    $entity->setState(0);
                } elseif($this->commentSettings['record_default_state'] == 2) {
                    $dangerousTrees = $this->commentSettings['record_dangerous_trees'];
                    $trees = $thread->getTarget()->getMaintrees();
                    $treesIterator = $trees->getIterator();
                    $dangerous = false;
                    while($treesIterator->valid()) {
                        $currentTree = $treesIterator->current()->getTree();
                        if($this->isDangerous($currentTree->getTreeIndex(), $dangerousTrees)) {
                            $dangerous = true;
                            break;
                        }
                        $treesIterator->next();
                    }
                    if($dangerous) {
                        $entity->setState(3);
                    } else {
                        $entity->setState(0);
                    }

                } else {
                    $entity->setState(3);
                }
            }

        } else {
            $entity->setState(3);
        }

    }

    private function isDangerous($treeIndex, $dangerousTrees) {
        foreach ($dangerousTrees as $key => $value) {
            if( $value == substr($treeIndex, 0, strlen($value)) ) {
                return true;
            }
        }
        return false;
    }

}