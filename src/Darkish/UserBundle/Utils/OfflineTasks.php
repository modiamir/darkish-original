<?php

namespace Darkish\UserBundle\Utils;



use Darkish\CategoryBundle\Entity\Record;
use Darkish\CategoryBundle\Entity\Interfaces\CanFavoriteInterface;
use Darkish\CategoryBundle\Entity\Interfaces\ClaimableInterface;
use Darkish\CategoryBundle\Entity\Interfaces\LikableInterface;
use Darkish\CategoryBundle\Entity\Interfaces\NotifiableInterface;
use Darkish\CategoryBundle\Entity\Interfaces\VisitableInterface;
use Darkish\UserBundle\Model\Task;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\DependencyInjection\Container;

class OfflineTasks
{
    private $container;

    const INVALID_ENTITY_TYPE = 90;
    const INVALID_ENTITY_ID = 91;
    const INVALID_TASK_VALUE = 92;

    const LIKE_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE = 10;

    const FAVORITE_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE = 20;
    const FAVORITE_FAVORITED_BEFORE = 21;
    const FAVORITE_NOT_FAVORITED_BEFORE = 22;

    const VISIT_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE = 30;

    const NOTIFY_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE = 40;
    const NOTIFY_NOTIFIED_BEFORE = 41;
    const NOTIFY_NOT_NOTIFIED_BEFORE = 42;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function handleTasks(ArrayCollection $tasks) {
        $taskIterator = $tasks->getIterator();
        $taskResults = [];
        while($taskIterator->valid())
        {
            $task = $taskIterator->current();
            try {
                $actionMethod = $task->getTaskType().'Task';
                if(method_exists ( $this , $actionMethod ))
                {
                    $result = $this->$actionMethod($task);
                    $taskResults[$task->getId()] = $result;
                }
                else
                {
                    $taskResults[$task->getId()] = '\''.$task->getTaskType(). '\' task doesn\'t exists';
                }
            } catch (\Exception $e) {
                $msg = $e->getMessage();
                $code = $e->getCode();
                $taskResults[$task->getId()] = [
                    'message' => $msg,
                    'code' => $code,
                ];
            }
            $taskIterator->next();
        }
        return $taskResults;
    }

    private function likeTask(Task $task) {

        switch($task->getEntityType())
        {
            case 'record':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Record');
                break;
            case 'news':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:News');
                break;
            case 'itinerary':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Itinerary');
                break;
            case 'comment':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCommentBundle:Comment');
                break;
            default:
                throw new \Exception('', self::INVALID_ENTITY_TYPE);
                break;
        }

        $entity = $repo->find($task->getEntityId());
        if(!$entity)
        {
            throw new \Exception('', self::INVALID_ENTITY_ID);
        }

        if(!$entity instanceof LikableInterface)
        {
            throw new \Exception('', self::INVALID_ENTITY_TYPE);
        }

        switch($task->getTaskValue())
        {
            case "1":
                if(in_array($task->getEntityType(), ['record', 'news', 'itinerary', 'comment']))
                {
                    $entity->setLikeCount( $entity->getLikeCount() + 1 );
                }
                else 
                {
                    throw new \Exception('', self::LIKE_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE);
                }
                break;
            case "-1":
                if(in_array($task->getEntityType(), ['record']))
                {
                    $entity->setLikeCount( $entity->getLikeCount() - 1 );
                }
                else
                {
                    throw new \Exception('', self::LIKE_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE);
                }

                break;
            default:
                throw new \Exception('', self::INVALID_TASK_VALUE);
                break;

        }


        $em = $this->container->get('doctrine')->getManager();
        $em->persist($entity);
        $em->flush();

        return true;
    }




    private function favoriteTask(Task $task) {
        /* @var $client \Darkish\UserBundle\Entity\Client */
        $client = $this->container->get('security.token_storage')->getToken()->getUser();

        switch($task->getEntityType())
        {
            case 'record':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Record');
                break;
            default:
                throw new \Exception('', self::INVALID_ENTITY_TYPE);
                break;
        }

        $entity = $repo->find($task->getEntityId());
        if(!$entity)
        {
            throw new \Exception('', self::INVALID_ENTITY_ID);
        }

        if(!$entity instanceof CanFavoriteInterface)
        {
            throw new \Exception('', self::INVALID_ENTITY_TYPE);
        }

        switch($task->getTaskValue())
        {
            case "1":
                if(in_array($task->getEntityType(), ['record']))
                {
                    if(!$client->getFavoriteRecords()->contains($entity))
                    {
                        $client->addFavoriteRecord($entity);
                        $entity->setFavoriteCount( $entity->getFavoriteCount() + 1 );
                    }
                    else
                    {
                        throw new \Exception('', self::FAVORITE_FAVORITED_BEFORE);
                    }
                }
                else
                {
                    throw new \Exception('', self::FAVORITE_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE);
                }
                break;
            case "-1":
                if(in_array($task->getEntityType(), ['record']))
                {
                    if($client->getFavoriteRecords()->contains($entity))
                    {
                        $client->removeFavoriteRecord($entity);
                        $entity->setFavoriteCount( $entity->getFavoriteCount() - 1 );
                    }
                    else
                    {
                        throw new \Exception('', self::FAVORITE_NOT_FAVORITED_BEFORE);
                    }

                }
                else
                {
                    throw new \Exception('', self::FAVORITE_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE);
                }

                break;
            default:
                throw new \Exception('', self::INVALID_TASK_VALUE);
                break;

        }


        $em = $this->container->get('doctrine')->getManager();
        $em->persist($client);
        $em->persist($entity);
        $em->flush();

        return true;
    }


    private function visitTask(Task $task) {

        switch($task->getEntityType())
        {
            case 'record':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Record');
                break;
            case 'news':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:News');
                break;
            case 'itinerary':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Itinerary');
                break;
            default:
                throw new \Exception('', self::INVALID_ENTITY_TYPE);
                break;
        }

        $entity = $repo->find($task->getEntityId());
        if(!$entity)
        {
            throw new \Exception('', self::INVALID_ENTITY_ID);
        }

        if(!$entity instanceof VisitableInterface)
        {
            throw new \Exception('', self::INVALID_ENTITY_TYPE);
        }

        switch($task->getTaskValue())
        {
            case "1":
                if(in_array($task->getEntityType(), ['record', 'news', 'itinerary']))
                {
                    $entity->setVisitCount( $entity->getVisitCount() + 1 );
                }
                else
                {
                    throw new \Exception('', self::VISIT_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE);
                }
                break;
            default:
                throw new \Exception('', self::INVALID_TASK_VALUE);
                break;

        }


        $em = $this->container->get('doctrine')->getManager();
        $em->persist($entity);
        $em->flush();

        return true;
    }


    private function notifyTask(Task $task) {

        switch($task->getEntityType())
        {
            case 'comment':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCommentBundle:Comment');
                break;
            default:
                throw new \Exception('', self::INVALID_ENTITY_TYPE);
                break;
        }

        $entity = $repo->find($task->getEntityId());
        if(!$entity)
        {
            throw new \Exception('', self::INVALID_ENTITY_ID);
        }

        if(!$entity instanceof NotifiableInterface)
        {
            throw new \Exception('', self::INVALID_ENTITY_TYPE);
        }

        switch($task->getTaskValue())
        {
            case "1":
                if(in_array($task->getEntityType(), ['comment']))
                {
                    if(!$entity->getNotify())
                    {
                        $entity->setNotify(true);
                    }
                    else
                    {
                        throw new \Exception('', self::NOTIFY_NOTIFIED_BEFORE);
                    }
                }
                else
                {
                    throw new \Exception('', self::NOTIFY_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE);
                }
                break;
            case "0":
                if(in_array($task->getEntityType(), ['comment']))
                {
                    if($entity->getNotify())
                    {
                        $entity->setNotify( false );
                    }
                    else
                    {
                        throw new \Exception('', self::NOTIFY_NOT_NOTIFIED_BEFORE);
                    }
                }
                else
                {
                    throw new \Exception('', self::NOTIFY_INCOMPATIBLE_TASK_VALUE_ENTITY_TYPE);
                }
                break;
            default:
                throw new \Exception('', self::INVALID_TASK_VALUE);
                break;

        }


        $em = $this->container->get('doctrine')->getManager();
        $em->persist($entity);
        $em->flush();

        return true;
    }

    private function claimTask(Task $task) {

        switch($task->getEntityType())
        {
            case 'comment':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCommentBundle:Comment');
                break;
            case 'classified':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Classified');
                break;
            case 'itinerary':
                $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Itinerary');
                break;
            default:
                throw new \Exception('', self::INVALID_ENTITY_TYPE);
                break;
        }

        $entity = $repo->find($task->getEntityId());
        if(!$entity)
        {
            throw new \Exception('', self::INVALID_ENTITY_ID);
        }

        if(!$entity instanceof ClaimableInterface)
        {
            throw new \Exception('', self::INVALID_ENTITY_TYPE);
        }

        $entity->setClaimType($task->getTaskValue());




        $em = $this->container->get('doctrine')->getManager();
        $em->persist($entity);
        $em->flush();

        return true;
    }
    
}