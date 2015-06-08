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
use Darkish\CommentBundle\Entity\Comment;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * 
 */
class ApiCommentController extends FOSRestController
{

    private $numOfComments = 5;
    private $numOfChilds = 5;

    /**
     * @RouteAnnot\Get("get_comments/{type}/{id}/{lowest_id}", requirements={
     *     "id": "\d+",
     *     "type":"news|record|forum|safarnameh",
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
            
            case 'safarnameh':
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

    /**
     * @RouteAnnot\Get("get_replies/{comment}/{lowestId}", requirements={
     *     "comment": "\d+",
     *     "lowestId": "\d+"
     * })
     * @View(serializerGroups={"api.list"})
     * 
     */
    public function getRepliesAction(Comment $comment, $lowestId) {
        $qb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('c');
        $qb->andWhere('c.parent = :pid')->setParameter('pid', $comment->getId());
        $qb->andWhere('c.state = 0');

        if($lowestId > 0) {
            $qb->andWhere('c.id < :lowestId')->setParameter('lowestId', $lowestId);
            $qb->setMaxResults($this->numOfChilds);
        }

        $qb->setMaxResults($this->numOfChilds);
        $qb->orderBy('c.id', 'DESC');
        

        
        $comments = $qb->getQuery()->getResult();
        return ['comments' => $comments];
    }



    /**
     * @RouteAnnot\Post("submit_comment")
     * @View(serializerGroups={"api.list"})
     * 
     */
    public function postCommentAction(Request $request) {
        $em = $this->getDoctrine()->getManager();


        /**
         * Fetching data from request and convert data to array
         */
        $data = $request->request->getIterator()->getArrayCopy();
        if(!isset($data['photos'])) {
            $data['photos'] = [];
        }
        // create a collection of constraints
        $collectionConstraint = new Assert\Collection(array(
            'type'                              =>  array(
                                                        new Assert\NotBlank(),
                                                        new Assert\Choice(
                                                                array(
                                                                    'choices' => array('record', 'forum', 'news', 'safarnameh'),
                                                                    'message' => "The value must be one of ('record', 'forum', 'news', 'safarnameh')"
                                                                )
                                                            )
                                                    ),
            'id'                                =>  array(
                                                        new Assert\NotBlank(),
                                                        new Assert\Type(array('type' => 'numeric')),
                                                        new Assert\Range(array('min'=> 1))
                                                    ),
            'photos'                            =>  array(
                                                        new Assert\Type(array('type' => 'array')),
                                                        new Assert\All(
                                                            array(
                                                                new Assert\Type(array('type' => 'numeric')),
                                                                new Assert\Range(array('min'=> 1))
                                                            )
                                                        )
                                                    ),
            'darkish_commentbundle_comment'     => new Assert\Collection(array(
                                                            'body' => array(
                                                                new Assert\NotBlank()
                                                            )
                                                        ))
        ));
        
        //validate data with created validation constraint
        $errorList = $this->get('validator')->validateValue($data, $collectionConstraint);


        //check if there is any error and send error as response
        if (count($errorList) != 0) {
            $errors = array();
            foreach ($errorList as $error) {
                // getPropertyPath returns form [email], so we strip it
                $field = substr($error->getPropertyPath(), 1, -1);

                $errors[$field] = $error->getMessage();
            }

            return array('success' => false, 'errors' => $errors);
        }
        


        $client = $this->getUser();
        

        
        switch ($data['type']) {
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
            
            case 'safarnameh':
                $entityType = 'DarkishCategoryBundle:Safarsaz';
                $threadType = 'Darkish\CommentBundle\Entity\SafarsazThread';
                break;
        }

        
        $entity = $this->getDoctrine()->getRepository($entityType)->find($data['id']);

        if(!$entity) {
            throw new \Exception("There is no entity of this type", 404);
        }

        $thread = $entity->getThread();

        if (!$thread) {
            $thread = new $threadType();
            $thread->setTarget($entity);
            $thread->setLastCommentAt(new \DateTime());
            $thread->setNumComments(1);
            $thread->setIsCommentable(true);
            $em->persist($thread);
        }

        

        
        $comment = new \Darkish\CommentBundle\Entity\ClientComment();
        
        $comment->setOwner($client);
        $comment->setThread($thread);
        $comment->setCreatedAt(new \DateTime());

        $form = $this->createForm(new \Darkish\CommentBundle\Form\CommentType(), $comment);
        $form->handleRequest($request);
        

        if ($form->isValid()) {
            
            if($request->get('photos')) {
                foreach ($request->get('photos') as $key => $value) {
                    $photo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->find($value);
                    $em->persist($photo);
                    $comment->addPhoto($photo);
                }
            }
            $em->persist($comment);

            if ($em->flush() !== false) {
                return new Response($this->get('jms_serializer')->serialize($comment, 'json', SerializationContext::create()->setGroups(array('comment.details', 'file.details'))));
            }
        }

        return new Response($this->get('jms_serializer')->serialize(array($form->getErrors()->__toString(),$request->request), 'json'));
    }
    

    /**
     * @RouteAnnot\Post("set_claim/{comment}/{claim}")
     * @View(serializerGroups={"api.list"})
     */
    public function setClaimAction(Comment $comment, \Darkish\CommentBundle\Entity\ClaimTypes $claim) {
        try {
            
            
            $comment->setClaimType($claim->getId());
            $comment->setState(3);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return new Response($this->get('jms_serializer')->serialize($comment, 'json', SerializationContext::create()->setGroups(array('comment.details', 'file.details'))));
        } catch(\Exception $e) {
            return new Response($e->getMessage());
        }
    }


    /**
     * @RouteAnnot\Post("like/{comment}")
     * @View(serializerGroups={"api.list"})
     * 
     */
    public function likeCommentAction(Comment $comment) {
        if(!$comment->getHasLiked()) {
            $em = $this->getDoctrine()->getManager();
            $cl = new \Darkish\CategoryBundle\Entity\CommentLike();
            $cl->setUserType('client');
            $cl->setUserId($this->getUser()->getId());
            $cl->setTarget($comment);
            $em->persist($cl);
            $comment->setLikeCount($comment->getLikeCount() + 1);
            $comment->setHasLiked(true);
            $em->persist($comment);
            $em->flush();
            return ["code"=>200, "message"=>'liked'];
            

        }
        return new Response('You have liked before', 403);
    }



    /**
     *
     * @RouteAnnot\Post("reply/{comment}")
     * @View(serializerGroups={"api.list"})
     */
    public function replyCommentAction(Request $request, Comment $comment) {

        /**
         * Fetching data from request and convert data to array
         */
        $data = $request->request->getIterator()->getArrayCopy();
        
        // create a collection of constraints
        $collectionConstraint = new Assert\Collection(array(
            
            'darkish_commentbundle_comment'     => new Assert\Collection(array(
                                                            'body' => array(
                                                                new Assert\NotBlank()
                                                            )
                                                        ))
        ));
        
        //validate data with created validation constraint
        $errorList = $this->get('validator')->validateValue($data, $collectionConstraint);


        //check if there is any error and send error as response
        if (count($errorList) != 0) {
            $errors = array();
            foreach ($errorList as $error) {
                // getPropertyPath returns form [email], so we strip it
                $field = substr($error->getPropertyPath(), 1, -1);

                $errors[$field] = $error->getMessage();
            }

            return array('success' => false, 'errors' => $errors);
        }
        

        $thread = $comment->getThread();
        
        if (!$thread->getIsCommentable()) {
            throw new AccessDeniedHttpException(sprintf('Thread is not commentable'));
        }

        if($comment->getState() != 0) {
            throw new AccessDeniedHttpException(sprintf('Comment is not active'));
        }
        
        $child = new \Darkish\CommentBundle\Entity\ClientComment();
        $child->setOwner($this->getUser());
        $child->setThread($thread);
        $child->setParent($comment);
        $child->setCreatedAt(new \DateTime());

        $form = $this->createForm(new \Darkish\CommentBundle\Form\CommentType(), $child);
        $form->handleRequest($request);
        

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($child);
            if ($em->flush() !== false) {
                return new Response($this->get('jms_serializer')->serialize($child, 'json', SerializationContext::create()->setGroups(array('comment.details', 'file.details'))));
            }
        }

        return new Response($this->get('jms_serializer')->serialize(array($form->getErrors()->__toString(),$request->request), 'json'));
    }

}
