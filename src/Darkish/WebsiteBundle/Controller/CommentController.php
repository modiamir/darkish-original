<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\CategoryBundle\Entity\Record;
use Darkish\CommentBundle\Entity\AnonymousComment;
use Darkish\CommentBundle\Entity\ClaimTypes;
use Darkish\CommentBundle\Entity\Comment;
use Darkish\CommentBundle\Entity\ForumTreeThread;
use Darkish\CommentBundle\Entity\RecordThread;
use Darkish\CommentBundle\Entity\ItineraryThread;
use Darkish\WebsiteBundle\Form\CommentType;
use FOS\RestBundle\Controller\Annotations\Route;
use Darkish\CommentBundle\Entity\NewsThread;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


/**
 * @Route("/", host="%domain%")
 */
class CommentController extends Controller
{
    public function indexAction($name)
    {
        $record= new Record();
        return $this->render('DarkishWebsiteBundle:Block:comment_list.html.twig', array('record' => $record));
    }

    /**
     * @param Request $request
     * @Route("/comment/post", name="website_comment_post")
     */
    public function postCommentAction(Request $request) {
        $claimTypes = $this->container->get('doctrine')
            ->getRepository('DarkishCommentBundle:ClaimTypes')
            ->findBy(['onlyCustomer' => false]);

        $comment = new AnonymousComment();
        $form = $this->createForm(new CommentType(), $comment,[
            'action' => $this->container->get('router')->generate('website_comment_post'),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            switch($request->get('entity_type'))
            {
                case 'record':
                    $entity = $this->getDoctrine()
                        ->getRepository('DarkishCategoryBundle:Record')
                        ->find($request->get('entity_id'));
                    $thread = $this->getDoctrine()->getRepository('DarkishCommentBundle:RecordThread')
                        ->findOneBy(['target'=>$request->get('entity_id')]);
                    if(!$thread) {
                        $thread = new RecordThread();
                        $thread->setTarget($entity);
                        $thread->setLastCommentAt(new \DateTime());
                        $thread->setNumComments(1);
                    }
                    $url = $this->generateUrl('website_record_single', ['record' => $entity->getRecordNumber()]);
                    break;
                case 'news':
                    $entity = $this->getDoctrine()
                        ->getRepository('DarkishCategoryBundle:News')
                        ->find($request->get('entity_id'));
                    $thread = $this->getDoctrine()->getRepository('DarkishCommentBundle:NewsThread')
                        ->findOneBy(['target'=>$request->get('entity_id')]);
                    if(!$thread) {
                        $thread = new NewsThread();
                        $thread->setTarget($entity);
                        $thread->setLastCommentAt(new \DateTime());
                        $thread->setNumComments(1);
                    }
                    $url = $this->generateUrl('website_news_single', ['news' => $entity->getId()]);
                    break;
                case 'forumtree':
                    $entity = $this->getDoctrine()
                        ->getRepository('DarkishCategoryBundle:ForumTree')
                        ->find($request->get('entity_id'));
                    $thread = $this->getDoctrine()->getRepository('DarkishCommentBundle:ForumTreeThread')
                        ->findOneBy(['target'=>$request->get('entity_id')]);
                    if(!$thread) {
                        $thread = new ForumTreeThread();
                        $thread->setTarget($entity);
                        $thread->setLastCommentAt(new \DateTime());
                        $thread->setNumComments(1);
                    }
                    $url = $this->generateUrl('website_forum_tree', ['treeIndex' => $entity->getTreeIndex()]);
                    break;
                case 'itinerary':
                    $entity = $this->getDoctrine()
                        ->getRepository('DarkishCategoryBundle:Itinerary')
                        ->find($request->get('entity_id'));
                    $thread = $this->getDoctrine()->getRepository('DarkishCommentBundle:ItineraryThread')
                        ->findOneBy(['target'=>$request->get('entity_id')]);
                    if(!$thread) {
                        $thread = new ItineraryThread();
                        $thread->setTarget($entity);
                        $thread->setLastCommentAt(new \DateTime());
                        $thread->setNumComments(1);
                    }
                    $parameters = [];
                    if($request->request->has('page')) {
                        $parameters['page'] = $request->request->get('page');
                    }
                    $parameters['commented'] = $request->get('entity_id');
                    $url = $this->generateUrl('website_itinerary', $parameters);
                    break;
            }
//            $comment->setCreatedAt(new \DateTime());
//            $comment->setReplyCount(0);
            $comment->setThread($thread);

            $photosIterators = $comment->getPhotos()->getIterator();
            while($photosIterators->valid()) {
                $photo = $photosIterators->current();
                $photo->setUserId(0);
                $photo->setOneup(true);
                /* @var $photo \Darkish\CategoryBundle\Entity\ManagedFile */
                $photosIterators->next();
            }

            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->persist($thread);

            $em->flush();

            $isChild = ($comment->getParent()) ? true : false;

            if($isChild) {
                return new JsonResponse([
                    'success' => true,
                    'result' => $this->renderView('DarkishWebsiteBundle:Comment:child.html.twig', [
                        'child' => $comment,
                        'claim_types' => $claimTypes
                    ])
                ]);
            } else {
                return new JsonResponse([
                    'success' => true,
                    'result' => $this->renderView('DarkishWebsiteBundle:Comment:comment.html.twig', [
                        'comment' => $comment,
                        'claim_types' => $claimTypes,
                        'entity_type' => $request->get('entity_type'),
                        'entity_id' => $request->get('entity_id'),
                    ])
                ]);
            }


        }



        switch($request->get('entity_type'))
        {
            case 'record':
                $url = $this->generateUrl('website_record_single', ['record' => $request->get('entity_id')]);
                break;
            case 'news':
                $url = $this->generateUrl('website_news_single', ['news' => $request->get('entity_id')]);
                break;
            case 'forumtree':
                $url = $this->generateUrl('website_forum_tree', ['treeIndex' => $request->get('entity_id')]);
                break;
            case 'itinerary':
                $parameters = [];
                if($request->request->has('page')) {
                    $parameters['page'] = $request->request->get('page');
                }
                $parameters['commented'] = $request->get('entity_id');
                $url = $this->generateUrl('website_itinerary', $parameters);
                break;
        }


        return new JsonResponse([
            'success' => false,
            'result' => $this->renderView('DarkishWebsiteBundle:Comment:create-form.html.twig', [
                'comment_form' => $form->createView(),
                'entity_type' => $request->get('entity_type'),
                'entity_id' => $request->get('entity_id'),
                'is_child' => ($comment->getParent()) ? true : false
            ])
        ]);

    }

    /**
     * @param Comment $parent
     * @return \Symfony\Component\Form\FormView
     * @Route("comment/get_form/{entityType}/{entityId}/{parent}", name="website_get_comment_form", options={"expose"=true});
     * @Template("DarkishWebsiteBundle:Comment:create-form.html.twig")
     */
    public function createFormAction($entityType, $entityId, Comment $parent = null) {
        $comment = new AnonymousComment();

        if($parent) {
            $comment->setParent($parent);
        }

        $form = $this->createForm(new CommentType(), $comment,[
            'action' => $this->container->get('router')->generate('website_comment_post'),
            'method' => 'POST',
        ]);
        return [
            'comment_form' => $form->createView(),
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'is_child' => true
        ];
    }


    /**
     * @param Comment $comment
     * @param $lastId
     * @return Response
     * @Route("comment/get_children/{comment}/{lastId}", name="website_get_comment_children", options={"expose"=true})
     */
    public function loadMoreChildren(Comment $comment, $lastId)
    {
        $children = $this->getDoctrine()
            ->getRepository('DarkishCommentBundle:Comment')
            ->getChildren($comment, $lastId);
        $childrenJson = [];
        $childrenJson['count'] = count($children);
        $childrenJson['children'] = $this->renderView('DarkishWebsiteBundle:Comment:get_children.html.twig',['children'=> $children]);

        return new JsonResponse($childrenJson);

    }




    /**
     * @Route("comment/like/{comment}", name="website_comment_like", options={"expose"=true})
     * @Method({"POST"})
     */
    public function likeCommentAction(Comment $comment) {
        $session = new Session();
        $session->start();

        $commentLikes = $session->get('commentLikes');

        if($commentLikes && in_array($comment->getId(), $commentLikes)) {
            throw new AccessDeniedHttpException();
        }


        if(true || !$comment->getHasLiked()) {
            $em = $this->getDoctrine()->getManager();
            $comment->setLikeCount($comment->getLikeCount() + 1);
            $em->persist($comment);
            $em->flush();
            if($commentLikes) {
                $commentLikes[] = $comment->getId();
            } else {
                $commentLikes = [];
                $commentLikes[] = $comment->getId();
            }
            $session->set('commentLikes', $commentLikes);
            return new Response($this->get('jms_serializer')->serialize($comment, 'json', SerializationContext::create()->setGroups(array('comment.details', 'file.details'))));
        }
        return new Response('You have liked before', 403);
    }


    /**
     * @Route("comment/report/{comment}/{report}", name="website_comment_report", options={"expose"=true})
     * @Method({"POST"})
     */
    public function reportCommentAction(Comment $comment, $report) {

        if($comment->getClaimType()) {
            throw new AccessDeniedHttpException();
        }

        $comment->setClaimType($report);

        $em = $this->getDoctrine()->getManager();
        $comment->setLikeCount($comment->getLikeCount() + 1);
        $em->persist($comment);
        $em->flush();
        return new Response($this->get('jms_serializer')->serialize($comment, 'json', SerializationContext::create()->setGroups(array('comment.details', 'file.details'))));

    }


}
