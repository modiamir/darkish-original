<?php

namespace Darkish\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\RestBundle\Controller\Annotations\Prefix,
    FOS\RestBundle\Controller\Annotations\NamePrefix,
    FOS\RestBundle\Controller\Annotations\RouteResource,
    FOS\RestBundle\Controller\Annotations\View,
    FOS\RestBundle\Controller\Annotations\QueryParam,
    FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializationContext;
use FOS\RestBundle\Controller\Annotations as RouteAnnot;

/**
 * 
 */
class ApiCommentController extends FOSRestController
{

    private $numOfComments = 5;

    /**
     * @RouteAnnot\Get("get_comments/{type}/{id}/{lowest_id}", requirements={
     *     "id": "\d+",
     *     "type":"news|record|forum|safarname",
     *     "lowest_id": "\d+"
     * })
     * @View(serializerGroups={"api.list"})
     */
    public function getLatestCommentsAction($type, $id, $lowest_id) {
        switch ($type) {
            case 'news':
                $entityType = 'DarkishCategoryBundle:News';
                $threadType = 'Darkish\CommentBundle\Entity\NewsThread';
                break;
            
            case 'record':
                $entityType = 'DarkishCategoryBundle:Record';
                $threadType = 'Darkish\CommentBundle\Entity\RecordThread';
                break;
            
            case 'forum':
                $entityType = 'DarkishCategoryBundle:ForumTree';
                $threadType = 'Darkish\CommentBundle\Entity\ForumTreeThread';
                break;
            
            case 'safarname':
                $entityType = 'DarkishCategoryBundle:Safarsaz';
                $threadType = 'Darkish\CommentBundle\Entity\SafarsazThread';
                break;
        }

        $entity = $this->getDoctrine()->getRepository($entityType)->find($id);

        if(!$entity) {
            throw new \Exception("There is no entity of this type", 404);
        }

        $thread = $entity->getThread();

        if(!$thread) {
            return [];  
        }


        $qb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('c');
        $qb->join('c.thread', 'th', 'WITH', 'th INSTANCE OF '.$threadType.'');
        $qb->where('th.id = :thid')->setParameter('thid', $thread->getId());
        $qb->andWhere('c.parent IS NULL');
        $qb->andWhere('c.state = 0');
        $qb->orderBy('c.id', 'DESC');
        $qb->setMaxResults($this->numOfComments);

        if($lowest_id > 0) {
            $qb->andWhere('c.id < :lowestId')->setParameter('lowestId', $lowest_id);
        }

        $comments = $qb->getQuery()->getResult();
        return ['comments' => $comments];
    }


    public function getReplies() {
        
    }

    


}
