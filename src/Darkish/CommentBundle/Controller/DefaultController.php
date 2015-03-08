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

class DefaultController extends Controller
{
    /**
     * @Route("/admin/comment")
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
     * @Route("admin/comment/ajax/search/{type}/{filter}/{keywordType}/{keyword}", defaults={"_format"="json", "keyword"=null})
     */
    public function searchCommentsAction($type, $filter, $keywordType, $keyword) {
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

			case 'safarsaz':
    			$qb->join('c.thread', 'th', 'WITH', 'th INSTANCE OF Darkish\CommentBundle\Entity\SafarsazThread');
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
                            return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default', 'comment.details'))));
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
                            return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default', 'comment.details'))));
                        }
                        break;

                    case 'safarsaz':
                        $safarsazes = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Safarsaz')->findBy(array('id'=>$keyword));
                        if(count($safarsazes)) {
                            $safarsaz = $safarsazes[0];
                            $th = $safarsaz->getThread();
                            $threadId = $th->getId();
                            $qb->where('th.id = :id')->setParameter('id', $threadId);

                        } else {
                            $result['comments'] = [];
                            $result['count'] = 0 ;
                            return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default', 'comment.details'))));
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
                            return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default', 'comment.details'))));
                        }
                        break;
                    default:
                        # code...
                        break;
                }
            }
            
        }

    	// $qb->where('');
    	// $qb->join('c.thread', 'th');
    	// 
    	
    	$comments = $qb->getQuery()->getResult();

    	$result = array();
        if($needOrganised) {
            $result['comments'] = $this->organiseComments($comments);    
        } else {
            $result['comments'] = $this->unorganiseComments($comments);    
        }
    	

    	$result['count'] = count($comments);
    	return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default', 'comment.details'))));

    }


    /**
     * @Route(
     *      "/admin/comment/organised",
     *      defaults={"_format" = "json"}
     * )
     */
    public function getOrganisedCommentsAction() {
    	// $comments = $this->container->get('fos_comment.manager.comment')->findCommentTreeByThread($thread);
    	$comments = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->findAll();
    	return new Response($this->get('jms_serializer')->serialize($this->organiseComments($comments), 'json', SerializationContext::create()->setGroups(array('Default'))));
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
                $result = $this->get('jms_serializer')->serialize(array('results'=>$qb->getQuery()->getResult()), 'json', SerializationContext::create()->setGroups(array('Default', 'record.list')));
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
                $result = $this->get('jms_serializer')->serialize(array('results' => $qb->getQuery()->getResult()), 'json', SerializationContext::create()->setGroups(array('Default', 'news.list')));
                break;

            case 'safarsaz':
                $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Safarsaz');
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
                $result = $this->get('jms_serializer')->serialize(array('results' => $qb->getQuery()->getResult()), 'json', SerializationContext::create()->setGroups(array('Default', 'safarsaz.list')));
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
                $result = $this->get('jms_serializer')->serialize(array('results' => $qb->getQuery()->getResult()), 'json', SerializationContext::create()->setGroups(array('Default', 'forumtree.list')));
                break;

            default:
                # code...
                break;
        }
        return new Response($result);
        
        
        
    }


    /**
     * @Route(
     *      "/admin/comment/ajax/get_entity_comments/{type}/{id}",
     *      defaults={"_format" = "json"}
     * )
     */
    public function getEntityCommentsAction($type, $id) {
        try {
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
                    $commentMan = $this->get('fos_comment.manager.comment');
                    /* @var $threadMan \FOS\CommentBundle\Entity\CommentManager */
                    $comments = $commentMan->findCommentsByThread($thread);
                    $count = count($comments);
                    $result['comments'] = $this->organiseComments($comments);
                    $result['count'] = $count;
                    return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default', 'comment.details'))));
                    return new Response(get_class($threadMan));
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
                    $commentMan = $this->get('fos_comment.manager.comment');
                    /* @var $threadMan \FOS\CommentBundle\Entity\CommentManager */
                    $comments = $commentMan->findCommentsByThread($thread);
                    $count = count($comments);
                    $result['comments'] = $this->organiseComments($comments);
                    $result['count'] = $count;
                    return new Response($this->get('jms_serializer')->serialize($result, 'json', SerializationContext::create()->setGroups(array('Default', 'comment.details'))));
                    break;

                case 'safarsaz':
                    # code...
                    break;

                case 'forum':
                    # code...
                    break;

                default:
                    # code...
                    break;
            }

        }catch(\Exception $e) {
            die($e->getMessage());
        }
        
    }

    /**
     * @Route(
     *      "/admin/comment/ajax/reply/{id}",
     *      defaults={"_format" = "json"}
     * )
     * @Method({"POST"})
     * 
     */
    public function replyCommentAction(Request $request, $id) {
        $thread = $this->container->get('fos_comment.manager.thread')->findThreadById($id);
        if (!$thread) {
            throw new NotFoundHttpException(sprintf('Thread with identifier of "%s" does not exist', $id));
        }
        
        if (!$thread->isCommentable()) {
            throw new AccessDeniedHttpException(sprintf('Thread "%s" is not commentable', $id));
        }

        $parent = $this->getValidCommentParent($thread, $request->request->get('parentId'));
        $commentManager = $this->container->get('fos_comment.manager.comment');
        // $comment = $commentManager->createComment($thread, $parent);
        $comment = new \Darkish\CommentBundle\Entity\OperatorComment();
        $comment->setOwner($this->get('security.context')->getToken()->getUser());
        $comment->setThread($thread);
        $comment->setParent($parent);
        $comment->setState(true);

        $form = $this->createForm(new \Darkish\CommentBundle\Form\CommentType(), $comment);
        $form->handleRequest($request);
        

        if ($form->isValid()) {
            if ($commentManager->saveComment($comment) !== false) {
                return new Response($this->get('jms_serializer')->serialize(array('comment'=> $comment, 'children'=>[]), 'json', SerializationContext::create()->setGroups(array('Default', 'comment.details'))));
            }
        }

        return new Response($this->get('jms_serializer')->serialize(array($form->getErrors()->__toString(),$request->request), 'json'));
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
}
