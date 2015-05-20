<?php

namespace Darkish\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\Serializer\SerializationContext;
use Darkish\CommentBundle\Entity\RecordThread;
use Darkish\CommentBundle\Entity\Comment;

class CommentController extends Controller
{

	private $numOfComments = 5;
	private $numOfChilds = 5;

	/**
	 * @Route("/customer/ajax/comment/search/{lowestId}", defaults={"_format"="json"})
	 * @Method({"POST"})
	 */
	public function searchAction(Request $request, $lowestId) {
		$user = $this->get('security.context')->getToken()->getUser();
		/* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
		$assistantAccess = $user->getAssistantAccess();
		$role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(4);
		if(!$assistantAccess->contains($role)) {
		    throw new AccessDeniedException();
		}

		$record = $user->getRecord();

		$thread = $record->getThread();
        if(!$thread) {
            $result['comments'] = [];
            return new Response($this->get('jms_serializer')->serialize($result, 'json'));
        }

		$qb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('c');
		$qb->join('c.thread', 'th', 'WITH', 'th INSTANCE OF Darkish\CommentBundle\Entity\RecordThread');
		$qb->where('th.id = :thid')->setParameter('thid', $thread->getId());
		$qb->andWhere('c.parent IS NULL');
		$qb->orderBy('c.id', 'DESC');
		$qb->setMaxResults($this->numOfComments);
		if($request->request->get('news')) {
			$qb->andWhere($qb->expr()->orX(
		       $qb->expr()->eq('c.unseenByCustomers', ':unseen'),
		       $qb->expr()->gt('c.unseenRepliesByCustomers', ':unseenRep')
		   ))->setParameter('unseen', true)->setParameter('unseenRep', 0);	
		}

		if($lowestId > 0) {
			$qb->andWhere('c.id < :lowestId')->setParameter('lowestId', $lowestId);
		}
		
		$comments = $qb->getQuery()->getResult();
		return new Response($this->get('jms_serializer')->serialize(array('comments'=>$comments), 'json', SerializationContext::create()->setGroups(array('comment.details', 'file.details'))));
	}


	/**
	 * @Route(
	 *     "/customer/ajax/comment/set_claim/{comment}",
	 *     defaults={"_format" = "json"}
	 * )
	 * @Method({"POST"})
	 * 
	 */
	public function setClaimAction(Comment $comment) {
	    try {
	    	$user = $this->get('security.context')->getToken()->getUser();
	    	/* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
	    	$assistantAccess = $user->getAssistantAccess();
	    	$role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(4);
	    	if(!$assistantAccess->contains($role)) {
	    	    throw new AccessDeniedException();
	    	}

	    	$record = $user->getRecord();

	    	if( !(($thread = $comment->getThread()) instanceof \Darkish\CommentBundle\Entity\RecordThread ) || 
	    		$thread->getTarget()->getId() != $record->getId() ) {
	    		throw new AccessDeniedException();	
	    	}
	    	
	        
	        $comment->setClaimType(4);
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
	 * @Route(
	 *     "/customer/ajax/comment/has_liked/{comment}",
	 *     defaults={"_format" = "json"}
	 *     
	 * )
	 */
	public function hasLikedAction(Darkish\CommentBundle\Entity\Comment $comment) {
	    
	    return new JsonResponse(array($this->hasLiked($comment)));

	}

	private function hasLiked($comment) {
	    $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:CommentLike');
	    $qb = $repo->createQueryBuilder('cl');
	    $qb->where("cl.userType = :userType")->andWhere('cl.userId = :userId')->andWhere('cl.target = :cid');
	    $qb->setParameter('userType', 'customer');
	    $qb->setParameter('userId', $this->get('security.context')->getToken()->getUser()->getId());
	    $qb->setParameter('cid', $comment->getId());
	    $result = $qb->getQuery()->getResult();
	    return count($result) > 0 ;
	}

	/**
	 * @Route(
	 *     "/customer/ajax/comment/like/{comment}"
	 * )
	 * @Method({"POST"})
	 * 
	 */
	public function likeCommentAction(Comment $comment) {
	    if(true || !$comment->getHasLiked()) {
	        $em = $this->getDoctrine()->getManager();
	        $cl = new \Darkish\CategoryBundle\Entity\CommentLike();
	        $cl->setUserType('customer');
	        $cl->setUserId($this->get('security.context')->getToken()->getUser()->getId());
	        $cl->setTarget($comment);
	        $em->persist($cl);
	        $comment->setLikeCount($comment->getLikeCount() + 1);
	        $comment->setHasLiked(true);
	        $em->persist($comment);
	        $em->flush();
	        return new Response($this->get('jms_serializer')->serialize($comment, 'json', SerializationContext::create()->setGroups(array('comment.details', 'file.details'))));

	    }
	    return new Response('You have liked before', 403);
	}


	/**
	 * @Route(
	 *      "/customer/ajax/comment/reply/{comment}",
	 *      defaults={"_format" = "json"}
	 * )
	 * @Method({"POST"})
	 * 
	 */
	public function replyCommentAction(Request $request, Comment $comment) {

		$user = $this->get('security.context')->getToken()->getUser();
		/* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
		$assistantAccess = $user->getAssistantAccess();
		$role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(4);
		if(!$assistantAccess->contains($role)) {
		    throw new AccessDeniedException();
		}

		$record = $user->getRecord();

		if( !(($thread = $comment->getThread()) instanceof \Darkish\CommentBundle\Entity\RecordThread ) || 
			$thread->getTarget()->getId() != $record->getId() ) {
			throw new AccessDeniedException();	
		}

	    
	    if (!$thread->getIsCommentable()) {
	        throw new AccessDeniedHttpException(sprintf('Thread "%s" is not commentable', $id));
	    }

	    
	    $child = new \Darkish\CommentBundle\Entity\CustomerComment();
	    $child->setOwner($user);
	    $child->setThread($thread);
	    $child->setParent($comment);
	    $child->setState(3);
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
	 *      "/customer/ajax/comment/post",
	 *      defaults={"_format" = "json"}
	 * )
	 * @Method({"POST"})
	 * 
	 */
	public function postCommentAction(Request $request) {

		$user = $this->get('security.context')->getToken()->getUser();
		/* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
		$assistantAccess = $user->getAssistantAccess();
		$role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(4);
		if(!$assistantAccess->contains($role)) {
		    throw new AccessDeniedException();
		}

		$record = $user->getRecord();
		$thread = $record->getThread();

		



		if( $thread && (!($thread  instanceof \Darkish\CommentBundle\Entity\RecordThread ) || 
			$thread->getTarget()->getId() != $record->getId() ) ) {
			throw new AccessDeniedException();	
		}

		if (!$thread) {
		    $thread = new \Darkish\CommentBundle\Entity\RecordThread();
		}

	    

	    
	    $comment = new \Darkish\CommentBundle\Entity\CustomerComment();
	    $comment->setOwner($user);
	    $comment->setThread($thread);
	    $comment->setState(3);
	    $comment->setCreatedAt(new \DateTime());

	    $form = $this->createForm(new \Darkish\CommentBundle\Form\CommentType(), $comment);
	    $form->handleRequest($request);
	    

	    if ($form->isValid()) {
	    	$em = $this->getDoctrine()->getManager();
	    	if($request->get('photos')) {
	    		foreach ($request->get('photos') as $key => $value) {
	    			$photo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->find($value['id']);
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
	 * @Route("/customer/ajax/comment/replies/{comment}/{lowestId}")
	 * @Method({"GET"})
	 */
	public function getReplies(Comment $comment, $lowestId) {
		$user = $this->get('security.context')->getToken()->getUser();
		/* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
		$assistantAccess = $user->getAssistantAccess();
		$role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(4);
		if(!$assistantAccess->contains($role)) {
		    throw new AccessDeniedException();
		}

		$record = $user->getRecord();

		if( !(($thread = $comment->getThread()) instanceof \Darkish\CommentBundle\Entity\RecordThread ) || 
			$thread->getTarget()->getId() != $record->getId() ) {
			throw new AccessDeniedException();	
		}

		$qb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('c');
		$qb->join('c.thread', 'th', 'WITH', 'th INSTANCE OF Darkish\CommentBundle\Entity\RecordThread');
		$qb->where('th.id = :thid')->setParameter('thid', $thread->getId());
		$qb->andWhere('c.parent = :pid')->setParameter('pid', $comment->getId());


		if($lowestId > 0) {
			$qb->andWhere('c.id < :lowestId')->setParameter('lowestId', $lowestId);
			$qb->setMaxResults($this->numOfChilds);
		} else {
			if($comment->getUnseenRepliesByCustomers() > 0) {
				$unseenQb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('c');
				$unseenQb->join('c.thread', 'th', 'WITH', 'th INSTANCE OF Darkish\CommentBundle\Entity\RecordThread');
				$unseenQb->where('th.id = :thid')->setParameter('thid', $thread->getId());
				$unseenQb->andWhere('c.parent = :pid')->setParameter('pid', $comment->getId());
				$unseenQb->andWhere('c.unseenByCustomers = :unseen')->setParameter('unseen', true);
				$unseenQb->orderBy('c.id', 'ASC');
				$unseenQb->setMaxResults(1);
				$unseenReply = $unseenQb->getQuery()->getResult();
				if(count($unseenReply)) {
					$unseenReply = $unseenReply[0];
				} else {
					$unseenReply = null;
				}
			}

			if($comment->getUnseenRepliesByCustomers() > 0 && $unseenReply != null) {
				$qb->andWhere('c.id >= :unseenid')->setParameter('unseenid', $unseenReply->getId());
			} else {
				$qb->setMaxResults($this->numOfChilds);
			}
		}
		

		



		
		$qb->orderBy('c.id', 'DESC');
		

		
		$comments = $qb->getQuery()->getResult();
		return new Response($this->get('jms_serializer')->serialize(array('comments'=>$comments), 'json', SerializationContext::create()->setGroups(array('comment.details', 'file.details'))));

	}


	/**
	 * @Route("/customer/ajax/comment/set_unseen_by_customer", defaults={"_format" = "json"})
	 * @Method({"POST"})
	 */
	public function setUnseenByCustomers(Request $request) {
		$user = $this->get('security.context')->getToken()->getUser();
		/* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
		$assistantAccess = $user->getAssistantAccess();
		$role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(4);
		if(!$assistantAccess->contains($role)) {
		    throw new AccessDeniedException();
		}

		$record = $user->getRecord();

		$thread = $record->getThread();
        if(!$thread) {
            return new JsonResponse(array('done'));
        }

        $qb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('c');
    	$qb->update()
    	    ->set('c.unseenByCustomers', ':unseen')
    	    ->setParameter('unseen', false)
    	    ->where($qb->expr()->in('c.id', $request->get('comments')))
    	    ->andWhere('c.thread = :thid')->setParameter('thid', $thread->getId());
		return new JsonResponse($qb->getQuery()->getResult());
	}


	/**
	 * @Route("/customer/ajax/comment/set_unseen_replies_by_customer/{comment}", defaults={"_format" = "json"})
	 * @Method({"POST"})
	 */
	public function setUnseenRepliesByCustomers(Comment $comment, Request $request) {
		$user = $this->get('security.context')->getToken()->getUser();
		/* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
		$assistantAccess = $user->getAssistantAccess();
		$role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(4);
		if(!$assistantAccess->contains($role)) {
		    throw new AccessDeniedException();
		}

		$record = $user->getRecord();

		$thread = $record->getThread();
        if(!$thread) {
            return new JsonResponse(array('done'));
        }

        if($comment->getThread()->getId() !== $thread->getId()) {
        	throw new AccessDeniedException();
        }

        $selectqb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('c');
        $selectqb
        	->select('count(c.id)')
        	->where($selectqb->expr()->in('c.id', $request->get('comments')))
        	->andWhere('c.parent = :parent')->setParameter('parent', $comment->getId());
        $count = $selectqb->getQuery()->getSingleScalarResult();
        
        $qb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('c');
    	$qb->update()
    	    ->set('c.unseenByCustomers', ':unseen')
    	    ->setParameter('unseen', false)
    	    ->where($qb->expr()->in('c.id', $request->get('comments')));
    	$qb->getQuery()->getResult();

    	$parentQb = $this->getDoctrine()->getRepository('DarkishCommentBundle:Comment')->createQueryBuilder('c');
    	if($comment->getUnseenRepliesByCustomers() >= $count) {
	    	$qb->update()
	    	    ->set('c.unseenRepliesByCustomers', 'c.unseenRepliesByCustomers - :count')
	    	    ->setParameter('count', $count)
	    	    ->where('c.id = :cid')->setParameter('cid', $comment->getId());
	    	$qb->getQuery()->getResult();
	    } else {
	    	$qb->update()
	    	    ->set('c.unseenRepliesByCustomers', ':zero')
	    	    ->setParameter('zero', 0)
	    	    ->where('c.id = :cid')->setParameter('cid', $comment->getId());
	    	$qb->getQuery()->getResult();
	    }
		return new JsonResponse(array('done'));
	}
}
