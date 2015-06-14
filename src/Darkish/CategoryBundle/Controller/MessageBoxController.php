<?php

namespace Darkish\CategoryBundle\Controller;

use Darkish\CategoryBundle\Entity\RecordLock;
use Darkish\CategoryBundle\Entity\RecordMainTree;
use Doctrine\Common\Collections\ArrayCollection as Collection;
use Doctrine\DBAL\DBALException;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolation;
use Darkish\CategoryBundle\Entity\Record;
use Darkish\CategoryBundle\Entity\MainTree;
use Darkish\CategoryBundle\Form\NewsType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use JMS\Serializer\Serializer as JMSSerializer;
use JMS\Serializer\SerializationContext;
use Darkish\CategoryBundle\Form\RecordType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Darkish\CategoryBundle\Entity\RecordRegisterCode;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class MessageBoxController extends Controller
{
	/**
	 * @Route("/", defaults={ "_format" = "json", "regenerate" = 0 })
	 */
	public function indexAction() {
		$operator = $this->getUser();
		$customer = $operator->getCustomer();
		if(!($customer instanceof \Darkish\CustomerBundle\Entity\Customer)) {
			throw new AccessDeniedHttpException();
			
		}
	    return $this->render('DarkishCategoryBundle:MessageBox:index.html.php');
	}

	/**
	 * @Route("/ajax/get_messages/{mode}/{modeId}")
	 */
	public function getMessages($mode, $modeId) {
		$operator = $this->getUser();
		$customer = $operator->getCustomer();
		if(!($customer instanceof \Darkish\CustomerBundle\Entity\Customer)) {
			throw new AccessDeniedHttpException();
			
		}
		
		$qb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Message')->createQueryBuilder('c');
		$qb->join('c.thread', 'th', 'WITH');
		$qb->where('th.customer = :cid')->setParameter('cid', $customer->getId());
		$qb->orderBy('c.id', 'Desc');
		
		switch ($mode) {
			case 'older':
				if($modeId > 0) {
					$qb->andWhere('c.id < :mid')->setParameter('mid', $modeId);
				}
				$qb->setMaxResults(20);
				break;
			case 'newer':
				if($modeId>0) {
					$qb->andWhere('c.id > :mid')->setParameter('mid', $modeId);	
				}
				break;
			
		}
		return new Response($this->get('jms_serializer')->serialize(['messages'=>$qb->getQuery()->getResult()],'json', SerializationContext::create()->setGroups(['thread.list', 'customer.details'])));
	}

	/**
	 * @Route("/ajax/reply/{thread}")
	 * @Method({"PUT"})
	 */
	public function replyAction(\Darkish\CategoryBundle\Entity\MessageThread $thread, Request $request) {
    	$operator = $this->getUser();
    	$customer = $operator->getCustomer();
    	if(!($customer instanceof \Darkish\CustomerBundle\Entity\Customer)) {
    		throw new AccessDeniedHttpException();
    		
    	}

	    $user = $this->getUser();
	    
	    if($thread->getCustomer()->getId() != $customer->getId()) {
	        throw new AccessDeniedException();   
	    }
	    
	    $em = $this->getDoctrine()->getManager();
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
}	