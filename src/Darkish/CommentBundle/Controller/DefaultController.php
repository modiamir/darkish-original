<?php

namespace Darkish\CommentBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use JMS\Serializer\SerializationContext;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Darkish\CommentBundle\Entity\Comment;

class DefaultController extends Controller
{

    private $numOfComments = 5;

    /**
     * @Route("/admin/comment" , name="forum")
     */
    public function indexAction()
    {
    	/* @var $sort \FOS\CommentBundle\Sorting\SortingFactory */
    	try {
    		$user = $this->get('security.context')->getToken()->getUser();
    		if(!$user->routeAccess('comment')) {
    		    throw new AccessDeniedException('Unauthorised access!');
    		}
    		return $this->render('DarkishCommentBundle:Default:index.html.php');


    	} catch(\Exception $e) {
    		return new Response($e->getMessage());
    	}
    	
    }

    /**
     * @Route(
     *      "/admin/comment/template/{name}"
     * )
     */
    public function getTemplateAction($name) {
        return $this->render('DarkishCommentBundle:Default:Templates/'.$name.'.php');
    }


    /**
     * 
     * @Route("admin/comment/ajax/search/{type}/{filter}/{keywordType}/{lowestId}/{keyword}/", defaults={"_format"="json", "keyword"=null})
     */
    public function searchCommentsAction($type, $filter, $keywordType, $lowestId, $keyword) {
        $needOrganised = true;
    	$repo = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment');
        // return new Response($this->get('jms_serializer')->serialize($repo->find(1), 'json', SerializationContext::create()->setGroups(array('Default', 'comment.details'))));
    	$qb = $repo->createQueryBuilder('c');
    	/* @var $qb \Doctrine\ORM\QueryBuilder */
    	switch ($type) {
    		case 'record':
    			$qb->join('c.thread', 'th', 'WITH', 'th INSTANCE OF Darkish\CommentBundle\Entity\RecordThread');
    			break;

			case 'news':
    			$qb->join('c.thread', 'th', 'WITH', 'th INSTANCE OF Darkish\CommentBundle\Entity\NewsThread');
    			break;

			case 'itinerary':
    			$qb->join('c.thread', 'th', 'WITH', 'th INSTANCE OF Darkish\CommentBundle\Entity\ItineraryThread');
    			break;

			case 'forum':
    			$qb->join('c.thread', 'th', 'WITH', 'th INSTANCE OF Darkish\CommentBundle\Entity\ForumTreeThread');
    			break;
    		
    		default:
    			# code...
    			break;
    	}
        if($filter == 'claimed') {
            $qb->where('c.claimType != 0');
            $needOrganised = false;
        }



        if($keywordType != "null" && $keyword != "null") {
            
            if($keywordType == 'text') {
                $needOrganised = false;
                $qb->where($qb->expr()->like('c.body', $qb->expr()->literal('%' . $keyword . '%')));    
            } else {
                switch ($type) {
                    case 'record':
                        $records = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->findBy(array('recordNumber'=>$keyword));
                        if(count($records)) {
                            $record = $records[0];
                            $th = $record->getThread();
                            $threadId = $th->getId();
                            $qb->where('th.id = :id')->setParameter('id', $threadId);
                        } else {
                            $result['comments'] = [];
                            $result['count'] = 0 ;
                            return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array('comment.details'))));
                        }
                        
                        break;

                    case 'news':
                        $news = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News')->findBy(array('id'=>$keyword));
                        if(count($news)) {
                            $new = $news[0];
                            $th = $new->getThread();
                            $threadId = $th->getId();
                            $qb->where('th.id = :id')->setParameter('id', $threadId);

                        } else {
                            $result['comments'] = [];
                            $result['count'] = 0 ;
                            return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));
                        }
                        break;

                    case 'itinerary':
                        $itineraries = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Itinerary')->findBy(array('id'=>$keyword));
                        if(count(itineraries)) {
                            $itinerary = $itineraies[0];
                            $th = $itinerary->getThread();
                            $threadId = $th->getId();
                            $qb->where('th.id = :id')->setParameter('id', $threadId);

                        } else {
                            $result['comments'] = [];
                            $result['count'] = 0 ;
                            return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));
                        }
                        break;

                    case 'forum':
                        $forums = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ForumTree')->findBy(array('treeIndex'=>$keyword));
                        if(count($forums)) {
                            $forum = $forums[0];
                            $th = $forum->getThread();
                            $threadId = $th->getId();
                            $qb->where('th.id = :id')->setParameter('id', $threadId);

                        } else {
                            $result['comments'] = [];
                            $result['count'] = 0 ;
                            return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            }
            
        }


        if($lowestId) {
            $qb->andWhere('c.id < :lowestId')->setParameter('lowestId', $lowestId);
        }

        $qb->setMaxResults($this->numOfComments);
        $qb->orderBy('c.id', 'Desc');

    	// $qb->where('');
    	// $qb->join('c.thread', 'th');
    	// 
    	$qb->andWhere('c.parent IS NULL');
    	$comments = $qb->getQuery()->getResult();

    	$result = array();
        
        $result['comments'] = $comments;    
    	

    	$result['count'] = count($comments);
    	return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));

    }


    /**
     * @Route(
     *      "/admin/comment/organised",
     *      defaults={"_format" = "json"}
     * )
     */
    public function getOrganisedCommentsAction() {
    	// $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
    	$qb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('cm');
        $qb->where('cm.parent IS NULL');
        $qb->setMaxResult(10);
        $comments = $qb->getQuery()->getResult();
    	return new Response($this->get('jms_serializer')->serialize($comments, 'json', SerializationContext::create()->setGroups(array('Default'))));
    }

    private function organiseComments($comments, $ignoreParents = null)
    {
        $tree = new \FOS\CommentBundle\Model\Tree();

        foreach ($comments as $comment) {
            $path = $tree;

            $ancestors = $comment->getAncestors();
            if (is_array($ignoreParents)) {
                $ancestors = array_diff($ancestors, $ignoreParents);
            }

            foreach ($ancestors as $ancestor) {
                $path = $path->traverse($ancestor);
            }

            $path->add($comment);
        }

        $tree = $tree->toArray();
        $tree = $this->get('fos_comment.sorting_factory')->getSorter()->sort($tree);

        return $tree;
    }

    private function unorganiseComments($comments, $ignoreParents = null) {

        $tree = new \FOS\CommentBundle\Model\Tree();

        foreach ($comments as $comment) {
            $path = $tree;

            $path->add($comment);
        }

        $tree = $tree->toArray();
        $tree = $this->get('fos_comment.sorting_factory')->getSorter()->sort($tree);

        return $tree;
    }


    /**
     * @Route(
     *      "/admin/comment/ajax/csrf",
     *      defaults={"_format" = "json"}
     * )
     */
    public function getCsrf() {
        $csrf = $this->get('form.csrf_provider'); //Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider by default
        $token = $csrf->generateCsrfToken(''); //Intention should be empty string, if you did not define it in parameters

        return new Response($token);
    }

    /**
     * @Route(
     *      "/admin/comment/ajax/get_entity_list/{type}/{by}/{keyword}",
     *      defaults={"_format" = "json"}
     * )
     */
    public function getEntityListAction($type, $by ,$keyword) {
        $repo = null;
        switch ($type) {
            case 'record':
                $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
                /* @var $qb \Doctrine\ORM\QueryBuilder */
                $qb = $repo->createQueryBuilder('e');
                switch ($by) {
                    case 'number':
                        $qb->where($qb->expr()->like('e.recordNumber', $qb->expr()->literal('%'.$keyword.'%')));
                        break;
                    case 'name':
                        $qb->where($qb->expr()->like('e.title', $qb->expr()->literal('%'.$keyword.'%')));
                        break;

                    default:
                        # code...
                        break;
                }
                $result = $this->get('jms_serializer')->serialize(array('results'=>$qb->getQuery()->getResult()), 'json', SerializationContext::create()->setGroups(array( 'record.list')));
                break;
            
            case 'news':
                $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News');
                /* @var $qb \Doctrine\ORM\QueryBuilder */
                $qb = $repo->createQueryBuilder('e');
                switch ($by) {
                    case 'number':
                        $qb->where($qb->expr()->like('e.id', $qb->expr()->literal('%'.$keyword.'%')));
                        break;
                    case 'name':
                        $qb->where($qb->expr()->like('e.title', $qb->expr()->literal('%'.$keyword.'%')));
                        break;

                    default:
                        # code...
                        break;
                }
                $result = $this->get('jms_serializer')->serialize(array('results' => $qb->getQuery()->getResult()), 'json', SerializationContext::create()->setGroups(array( 'news.list')));
                break;

            case 'itinerary':
                $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Itinerary');
                /* @var $qb \Doctrine\ORM\QueryBuilder */
                $qb = $repo->createQueryBuilder('e');
                switch ($by) {
                    case 'number':
                        $qb->where($qb->expr()->like('e.id', $qb->expr()->literal('%'.$keyword.'%')));
                        break;
                    case 'name':
                        $qb->where($qb->expr()->like('e.title', $qb->expr()->literal('%'.$keyword.'%')));
                        break;

                    default:
                        # code...
                        break;
                }
                $result = $this->get('jms_serializer')->serialize(array('results' => $qb->getQuery()->getResult()), 'json', SerializationContext::create()->setGroups(array( 'itinerary.list')));
                break;

            case 'forum':
                $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ForumTree');
                /* @var $qb \Doctrine\ORM\QueryBuilder */
                $qb = $repo->createQueryBuilder('e');
                switch ($by) {
                    case 'number':
                        # code...
                        break;
                    case 'name':
                        # code...
                        break;

                    default:
                        # code...
                        break;
                }
                $result = $this->get('jms_serializer')->serialize(array('results' => $qb->getQuery()->getResult()), 'json', SerializationContext::create()->setGroups(array( 'forumtree.list')));
                break;

            default:
                # code...
                break;
        }
        return new Response($result);
        
        
        
    }


    /**
     * @Route(
     *      "/admin/comment/ajax/get_entity_comments/{type}/{id}/{lowestId}", defaults={"lowestId" = 0},
     *      defaults={"_format" = "json"}
     * )
     */
    public function getEntityCommentsAction($type, $id, $lowestId = 0) {
        switch ($type) {
            case 'record':
                $record = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->find($id);
                if(!$record) {
                    return new Response('Record not found', 404);
                }
                $thread = $record->getThread();
                if(!$thread) {
                    $result['comments'] = [];
                    $result['count'] = 0 ;
                    return new Response($this->get('jms_serializer')->serialize($result, 'json'));
                }
                $repo = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment');
                $qb = $repo->createQueryBuilder('c');
                $qb->where('c.thread = :thid')->setParameter('thid', $thread->getId());
                $qb->orderBy('c.id', 'Desc');
                if($lowestId > 0) {
                    $qb->andWhere('c.id < :lowestId')->setParameter('lowestId', $lowestId);
                }
                $qb->setMaxResults($this->numOfComments);
                $qb->andWhere('c.parent IS NULL');
                $comments = $qb->getQuery()->getResult();
                $count = count($comments);
                $result['comments'] = $comments;
                $result['count'] = $count;
                return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));
                break;
            
            case 'news':
                $news = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News')->find($id);
                if(!$news) {
                    return new Response('News not found', 404);
                }
                $thread = $news->getThread();
                if(!$thread) {
                    $result['comments'] = [];
                    $result['count'] = 0 ;
                    return new Response($this->get('jms_serializer')->serialize($result, 'json'));
                }
                $repo = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment');
                $qb = $repo->createQueryBuilder('c');
                $qb->where('c.thread = :thid')->setParameter('thid', $thread->getId());
                $qb->orderBy('c.id', 'Desc');
                if($lowestId > 0) {
                    $qb->andWhere('c.id < :lowestId')->setParameter('lowestId', $lowestId);
                }
                $qb->setMaxResults($this->numOfComments);
                $qb->andWhere('c.parent IS NULL');
                $comments = $qb->getQuery()->getResult();
                $count = count($comments);
                $result['comments'] = $comments;
                $result['count'] = $count;
                return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));
                break;

            case 'itinerary':
                $itinerary = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Itinerary')->find($id);
                if(!$itinerary) {
                    return new Response('Itinerary not found', 404);
                }
                $thread = $itinerary->getThread();
                if(!$thread) {
                    $result['comments'] = [];
                    $result['count'] = 0 ;
                    return new Response($this->get('jms_serializer')->serialize($result, 'json'));
                }
                $repo = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment');
                $qb = $repo->createQueryBuilder('c');
                $qb->where('c.thread = :thid')->setParameter('thid', $thread->getId());
                $qb->orderBy('c.id', 'Desc');
                if($lowestId > 0) {
                    $qb->andWhere('c.id < :lowestId')->setParameter('lowestId', $lowestId);
                }
                $qb->setMaxResults($this->numOfComments);
                $qb->andWhere('c.parent IS NULL');
                $comments = $qb->getQuery()->getResult();
                $count = count($comments);
                $result['comments'] = $comments;
                $result['count'] = $count;
                return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));
                break;

            case 'forum':
                $forum = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ForumTree')->find($id);
                if(!$forum) {
                    return new Response('Forum not found', 404);
                }
                $thread = $forum->getThread();
                if(!$thread) {
                    $result['comments'] = [];
                    $result['count'] = 0 ;
                    return new Response($this->get('jms_serializer')->serialize($result, 'json'));
                }
                $repo = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment');
                $qb = $repo->createQueryBuilder('c');
                $qb->where('c.thread = :thid')->setParameter('thid', $thread->getId());
                $qb->orderBy('c.id', 'Desc');
                if($lowestId > 0) {
                    $qb->andWhere('c.id < :lowestId')->setParameter('lowestId', $lowestId);
                }
                $qb->setMaxResults($this->numOfComments);
                $qb->andWhere('c.parent IS NULL');
                $comments = $qb->getQuery()->getResult();
                $count = count($comments);
                $result['comments'] = $comments;
                $result['count'] = $count;
                return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));
                break;

            default:
                # code...
                break;
        }
        
    }

    /**
     * @Route(
     *      "/admin/comment/ajax/reply/{comment}",
     *      defaults={"_format" = "json"}
     * )
     * @Method({"POST"})
     * 
     */
    public function replyCommentAction(Request $request, Comment $comment) {
        
        $thread = $comment->getThread();
        
        if (!$thread->getIsCommentable()) {
            throw new AccessDeniedHttpException(sprintf('Thread is not commentable'));
        }

        if($comment->getState() != 0) {
            throw new AccessDeniedHttpException(sprintf('Comment is not active'));
        }
        
        $child = new \Darkish\CommentBundle\Entity\OperatorComment();
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


    /**
     * @Route(
     *      "/admin/comment/ajax/post_comment/{type}/{id}",
     *      defaults={"_format" = "json"}
     * )
     * @Method({"POST"})
     * 
     */
    public function postCommentAction($type, $id, Request $request) {

        $em = $this->getDoctrine()->getManager();

        switch ($type) {
            case 'record':
                $entity = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->find($id);
                if(!$entity->getCommentable()) {
                    return new Response("This record is not commentable", 401);
                }
                $state = $entity->getCommentDefaultState();

                break;
            
            case 'news':
                $entity = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News')->find($id);
                if(!$entity->getCommentable()) {
                    return new Response("This news is not commentable", 401);
                }
                $state = $entity->getCommentDefaultState();
                break;

            case 'itinerary':
                $entity = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Itinerary')->find($id);
                $state = 0;
                break;

            case 'forum':
                $entity = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ForumTree')->find($id);
                $state = 0;
                break;

            default:
                # code...
                break;
        }
        if(!$entity) {
            throw new NotFoundHttpException(sprintf('Entity of type "%s" with identifier of "%s" does not exist', $type, $id));
        }

        $thread = $entity->getThread();
        if (!$thread) {
            switch ($type) {
                case 'record':
                    $thread = new \Darkish\CommentBundle\Entity\RecordThread();
                    break;

                case 'news':
                    $thread = new \Darkish\CommentBundle\Entity\NewsThread();
                    break;

                case 'itinerary':
                    $thread = new \Darkish\CommentBundle\Entity\ItineraryThread();
                    break;

                case 'forum':
                    $thread = new \Darkish\CommentBundle\Entity\ForumTreeThread();
                    break;
                
                default:
                    # code...
                    break;
            }
            $thread->setIsCommentable(true);
            $thread->setTarget($entity);
            $thread->setLastCommentAt(new \DateTime());
            $thread->setNumComments(0);
            $em->persist($thread);
        }

        


        if (!$thread->getIsCommentable()) {
            throw new AccessDeniedHttpException(sprintf('Thread "%s" is not commentable', $id));
        }
        
        $commentManager = $this->container->get('fos_comment.manager.comment');
        // $comment = $commentManager->createComment($thread, $parent);
        $comment = new \Darkish\CommentBundle\Entity\OperatorComment();
        $comment->setOwner($this->get('security.context')->getToken()->getUser());
        $comment->setThread($thread);
        $comment->setState($state);
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
                return new Response($this->get('jms_serializer')->serialize(array('comment'=> $comment, 'children'=>[]), 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));
            }
        }

        return new Response($this->get('jms_serializer')->serialize(array($form->getErrors()->__toString(),$request->request), 'json'));
    }



    /**
     * @Route(
     *      "/admin/comment/ajax/get_replies/{comment}/{lowestId}",
     *      defaults={"_format" = "json"}
     * )
     */
    public function getRepliesAction(Comment $comment, $lowestId) {
        $qb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('c');
        $qb->andWhere('c.parent = :pid')->setParameter('pid', $comment->getId());
        $qb->andWhere('c.state = 0');

        if($lowestId > 0) {
            $qb->andWhere('c.id < :lowestId')->setParameter('lowestId', $lowestId);
            $qb->setMaxResults($this->numOfComments);
        }

        $qb->setMaxResults($this->numOfComments);
        $qb->orderBy('c.id', 'DESC');
        

        
        $comments = $qb->getQuery()->getResult();
        return new Response($this->get('jms_serializer')->serialize(['children' => $comments], 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));
    }


    /**
     * Checks if a comment belongs to a thread. Returns the comment if it does.
     *
     * @param ThreadInterface $thread    Thread object
     * @param mixed           $commentId Id of the comment.
     *
     * @return CommentInterface|null The comment.
     */
    private function getValidCommentParent($thread, $commentId)
    {
        if (null !== $commentId) {
            $comment = $this->container->get('fos_comment.manager.comment')->findCommentById($commentId);
            if (!$comment) {
                throw new NotFoundHttpException(sprintf('Parent comment with identifier "%s" does not exist', $commentId));
            }

            if ($comment->getThread() !== $thread) {
                throw new NotFoundHttpException('Parent comment is not a comment of the given thread.');
            }

            return $comment;
        }
    }

    /**
     * @Route(
     *     "/admin/comment/ajax/delete/{id}",
     *      defaults={"_format" = "json"}
     * )
     * @Method({"PUT"})
     */
    public function deleteCommentAction($id) {
        $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByCommentId($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->find($id));
        foreach($comments as $comment) {
            $em->remove($comment['comment']);
        }
        $em->flush();
        return new Response($this->get('jms_serializer')->serialize('ok', 'json'));

    }


    /**
     * @Route(
     *     "/admin/comment/ajax/set_claim/{comment}/{claim}",
     *     defaults={"_format" = "json"}
     * )
     * @Method({"PUT"})
     * 
     */
    public function setClaimAction(\Darkish\CommentBundle\Entity\Comment $comment, $claim) {
        try {
            $comment->setClaimType($claim);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return new Response('done');
        } catch(\Exception $e) {
            return new Response($e->getMessage());
        }
    }   


    /**
     * @Route(
     *     "/admin/comment/ajax/get_claim_types",
     *     defaults={"_format" = "json"}
     * )
     */
    public function getClaimTypes() {
        return new Response($this->get('jms_serializer')->serialize($this->getDoctrine()->getRepository('DarkishCommentBundle:ClaimTypes')->findAll(), 'json'));
    }

    /**
     * @Route(
     *     "/admin/comment/ajax/clear_claim/{comment}",
     *     defaults={"_format" = "json"}
     * )
     */
    public function clearClaim(\Darkish\CommentBundle\Entity\Comment $comment) {
        try {
            $comment->setClaimType(0);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return new Response('done');
        }catch(\Exception $e)  {
            return new Response($e->getMessage());   
        }
    }

    /**
     * @Route(
     *     "/admin/comment/ajax/set_state/{comment}/{state}",
     *     defaults={"_format" = "json"}
     * )
     * @Method({"PUT"})
     * 
     */
    public function setState(\Darkish\CommentBundle\Entity\Comment $comment, $state) {
        try {
            $comment->setState($state);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            return new Response('done');
        } catch(\Exception $e) {
            return new Response($e->getMessage());
        }
    }


    /**
     * @Route(
     *     "/admin/comment/ajax/get_forum_tree",
     *     defaults={"_format" = "json"}
     * )
     * 
     */
    public function getForumTreeAction() {



        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:ForumTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product ForumTree */
            $node['id'] = $product->getId();
            $node['treeIndex'] = $product->getTreeIndex();
            $node['upTreeIndex'] = $product->getUpTreeIndex();
            $node['title'] = $product->getTitle();
            $node['parent_tree_title'] = $product->getParentTreeTitle();
            $tree[$key] = $node;
        }
        $hierarchy = $this->buildTree($tree);
        return new Response(
            json_encode($hierarchy),
            200
        );
    }

    /**
     * @Route(
     *     "/admin/comment/ajax/get_main_tree",
     *     defaults={"_format" = "json"}
     * )
     * 
     */
    public function getMainTreeAction() {



        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:MainTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product ForumTree */
            $node['id'] = $product->getId();
            $node['treeIndex'] = $product->getTreeIndex();
            $node['upTreeIndex'] = $product->getUpTreeIndex();
            $node['title'] = $product->getTitle();
            $node['parent_tree_title'] = $product->getParentTreeTitle();
            $tree[$key] = $node;
        }
        $hierarchy = $this->buildTree($tree);
        return new Response(
            json_encode($hierarchy),
            200
        );
    }


    /**
     * @Route(
     *     "/admin/comment/ajax/get_news_tree",
     *     defaults={"_format" = "json"}
     * )
     * 
     */
    public function getNewsTreeAction() {



        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:NewsTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product ForumTree */
            $node['id'] = $product->getId();
            $node['treeIndex'] = $product->getTreeIndex();
            $node['upTreeIndex'] = $product->getUpTreeIndex();
            $node['title'] = $product->getTitle();
            $node['parent_tree_title'] = $product->getParentTreeTitle();
            $tree[$key] = $node;
        }
        $hierarchy = $this->buildTree($tree);
        return new Response(
            json_encode($hierarchy),
            200
        );
    }


    private function buildTree(array $elements, $parentId = "00") {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['upTreeIndex'] === $parentId) {
                $children = $this->buildTree($elements, $element['treeIndex']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    /**
     * @Route(
     *     "/admin/comment/ajax/has_liked/{cid}",
     *     defaults={"_format" = "json"}
     *     
     * )
     */
    public function hasLikedAction($cid) {
        
        return new Response($this->hasLiked($cid));

    }

    private function hasLiked($cid) {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:CommentLike');
        $qb = $repo->createQueryBuilder('cl');
        $qb->where("cl.userType = :userType")->andWhere('cl.userId = :userId')->andWhere('cl.target = :cid');
        $qb->setParameter('userType', 'operator');
        $qb->setParameter('userId', $this->get('security.context')->getToken()->getUser()->getId());
        $qb->setParameter('cid', $cid);
        $result = $qb->getQuery()->getResult();
        return count($result) > 0 ;
    }

    /**
     * @Route(
     *     "/admin/comment/ajax/like/{comment}"
     * )
     * @Method({"POST"})
     * 
     */
    public function likeCommentAction(\Darkish\CommentBundle\Entity\Comment $comment) {
        if(true || !$this->hasLiked($comment->getId())) {
            $em = $this->getDoctrine()->getManager();
            $cl = new \Darkish\CategoryBundle\Entity\CommentLike();
            $cl->setUserType('operator');
            $cl->setUserId($this->get('security.context')->getToken()->getUser()->getId());
            $cl->setTarget($comment);
            $em->persist($cl);
            $comment->setLikeCount($comment->getLikeCount() + 1);
            $em->persist($comment);
            $em->flush();
            return new Response('done');

        } 
        return new Response('You have liked before', 403);
    }


    /**
     * @Route("/admin/comment/ajax/send_message/{comment}")
     * @Method({"PUT"})
     */
    public function sendMessageAction(\Darkish\CommentBundle\Entity\Comment $comment, Request $request) {

        if($comment->getOwnerType() != 'client') {
            throw new AccessDeniedHttpException();
        }

        $client = $comment->getOwner();
        $operator = $this->getUser();
        $customer = $operator->getCustomer();
        if(!($customer instanceof \Darkish\CustomerBundle\Entity\Customer)) {
            throw new AccessDeniedHttpException();    
        }

        $thread = $this->getDoctrine()->getRepository('DarkishCategoryBundle:PrivateMessageThread')
                                      ->findOneBy(['customer' => $customer->getId(), 'client' => $client->getId()]);

        $em = $this->getDoctrine()->getManager();
        if(!($thread instanceof \Darkish\CategoryBundle\Entity\PrivateMessageThread)) {
            $thread = new \Darkish\CategoryBundle\Entity\PrivateMessageThread();
            $thread->setClient($client);
            $thread->setCustomer($customer);
            $thread->setLastRecordSeen(0);
            $thread->setLastClientSeen(0);
            $thread->setLastRecordDelivered(0);
            $thread->setLastClientDelivered(0);
            $thread->setDeletedByRecord(false);
            $thread->setDeletedByClient(false);
            $em->persist($thread);
        }
        
        
        $msg = new \Darkish\CategoryBundle\Entity\Message();
        $msg->setCreated(new \DateTime());
        $msg->setThread($thread);
        $msg->setFrom('record');
        $msg->setText($request->get('body'));
        $msg->setCustomer($customer);
        $em->persist($msg);

        $em->flush();

        $serialized = $this->get('jms_serializer')->serialize($msg, 'json'
            ,SerializationContext::create()->setGroups(array('thread.list', 'customer.details')));

        return new Response($serialized);
    }

    /**
     * @Route("/admin/comment/ajax/change_tree/{comment}/{forumTree}")
     * @Method({"PUT"})
     */
    public function changeForumTree(Comment $comment, \Darkish\CategoryBundle\Entity\ForumTree $forumTree) {
        $em = $this->getDoctrine()->getManager();
        $threadRepo = $this->getDoctrine()->getRepository('DarkishCommentBundle:ForumTreeThread');
        $newThread = $threadRepo->findOneBy(['target' => $forumTree->getId()]);
        if (!$newThread) {
            
            $newThread = new \Darkish\CommentBundle\Entity\ForumTreeThread();
            $newThread->setIsCommentable(true);
            $newThread->setTarget($forumTree);
            $newThread->setLastCommentAt(new \DateTime());
            $newThread->setNumComments(0);
            $em->persist($newThread);
        }        
        $comment->setThread($newThread);
        $em->persist($comment);
        $em->flush();
        return new Response($this->get('jms_serializer')->serialize($comment, 'json', SerializationContext::create()->setGroups(array( 'comment.details'))));
    }
}
