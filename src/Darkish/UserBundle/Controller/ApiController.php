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


/**
 * 
 */
class ApiController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *  description="Create a new Object",
     *  input="Your\Namespace\Form\Type\YourType",
     *  output="Your\Namespace\Class",
     *  resource="User"
     * )
     * 
     * @View()
     */
    public function getTestAction()
    {
    	$data = 'asd';

        $view = $this->view($data, 200);
        $view->setTemplateVar('products');
        return $view;

    }

    /**
     * This route is for login request. with this route you send phone number (username) and device id
     * and server will generate an approve code for you that will save in database and send to user via sms.
     * Note that a user can request for approve code only three times per hour.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="This is the login request  API method",
     *  parameters={
     *      {"name"="phone", "dataType"="string", "required"=true, "description"="phone number"},
     *      {"name"="deviceـid", "dataType"="string", "required"=true, "description"="device id"}
     *  }
     * )
     * 
     * @View()
     */
    public function postLoginAction(Request $request) {
    	if(!$request->request->has('phone') || strlen($request->request->get('phone')) < 1) {
    		throw new HttpException(400, "'phone' is required !");
    	}
    	$username = $request->request->get('phone');
    	if(!$request->request->has('device_id') || strlen($request->request->get('device_id')) < 1) {
    		throw new HttpException(400 ,"'device_id' is required !");
    	}
    	$deviceId = $request->request->get('device_id');

    	/**
    	 * Delete expired approve codes
    	 * 
    	 */
    	$this->expireApproveCodes($deviceId, $username);

    	/**
    	 * Check tokens for this device_id and username that submit in last hour.
    	 * if there is three device id then reject login reauest.
    	 * 
    	 */
    	$approveCodeRepo = $this->getDoctrine()->getRepository('DarkishUserBundle:ApproveCode');
    	$acqb = $approveCodeRepo->createQueryBuilder('ac');
    	/* @var $acqb \Doctrine\ORM\QueryBuilder */
    	// $acqb->select('count(ac)');
    	$acqb->where('ac.deviceId = :deviceid');
    	$acqb->andWhere('ac.username = :username');
    	
    	$date = new \DateTime();
		$date->modify('-1 hour');
		$acqb->andWhere('ac.created > :date');
		$acqb->orderBy('ac.created', 'ASC');
		$acqb->setParameter('deviceid', $request->request->get('device_id'));
		$acqb->setParameter('username', $username);
		$acqb->setParameter('date', $date);
    	$result = $acqb->getQuery()->getResult();
    	$count = count($result);
    	if($count >= 3) {
    		$first = $result[0];
    		$firstDate = $first->getCreated()->format('Y-m-d H:i:s');
    		/* @var $first \Darkish\UserBundle\Entity\ApproveCode */
    		throw new HttpException(403, "You cannot submit login request until $firstDate");
    	}

    	/**
    	 * Now User can request for login. before creating new approve code we disable all preivious
    	 * approve codes
    	 */
    	$this->disableApproveCodes($deviceId, $username);

    	/**
    	 * Now create new approve code 
    	 */
    	$ac = new \Darkish\UserBundle\Entity\ApproveCode();
    	$ac->setDeviceId($deviceId);
    	$ac->setUsername($username);
    	$ac->setCreated(new \DateTime());
    	$expireDate = new \DateTime();
		$expireDate->modify('1 hour');
    	$ac->setExpire($expireDate);
    	$ac->setStatus(1);
    	$code = rand(100000, 999999);
    	$ac->setCode($code);

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($ac);
    	$em->flush();
    	return $this->view("The approve code created and sent you via sms. (This is code: $code )", 200);
    	
    }


    private function expireApproveCodes($deviceId, $username) {
    	$date = new \DateTime();
    	$em = $this->getDoctrine()->getManager();
    	$q = $em->createQuery('delete from Darkish\UserBundle\Entity\ApproveCode ac 
    		WHERE ac.expire < :date
    		and ac.deviceId = :deviceid 
    		and ac.username = :username

    		');
    	$q->setParameter('date', $date);
    	$q->setParameter('deviceid', $deviceId);
    	$q->setParameter('username', $username);
		$numUpdated = $q->execute();
    }

    private function disableApproveCodes($deviceId, $username) {
    	$date = new \DateTime();
    	$em = $this->getDoctrine()->getManager();
    	$q = $em->createQuery('update Darkish\UserBundle\Entity\ApproveCode ac set ac.status = 0 where
    		ac.deviceId = :deviceid 
    		and ac.username = :username
		');
    	$q->setParameter('deviceid', $deviceId);
    	$q->setParameter('username', $username);
		$numUpdated = $q->execute();
    }

    /**
     * This method is for activate login. 
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="This is the approve login code request API method",
     *  parameters={
     *      {"name"="phone", "dataType"="string", "required"=true, "description"="phone number"},
     *      {"name"="deviceـid", "dataType"="string", "required"=true, "description"="device id"},
     *      {"name"="approve_code", "dataType"="string", "required"=true, "description"="approve code"}
     *  }
     * )
     * 
     * @View()
     */
    public function postApproveAction(Request $request) {
    	if(!$request->request->has('phone') || strlen($request->request->get('phone')) < 1) {
    		throw new HttpException(400, "'phone' is required !");
    	}
    	$username = $request->request->get('phone');
    	if(!$request->request->has('device_id') || strlen($request->request->get('device_id')) < 1) {
    		throw new HttpException(400 ,"'device_id' is required !");
    	}
    	$deviceId = $request->request->get('device_id');
    	if(!$request->request->has('approve_code') || strlen($request->request->get('approve_code')) < 1) {
    		throw new HttpException(400 ,"'approve_code' is required !");
    	}
    	$approveCode = $request->request->get('approve_code');

    	/**
    	 * Delete expired approve codes
    	 * 
    	 */
    	$this->expireApproveCodes($deviceId, $username);

    	/**
    	 * 
    	 */
    	$approveCodeRepo = $this->getDoctrine()->getRepository('DarkishUserBundle:ApproveCode');
    	$acqb = $approveCodeRepo->createQueryBuilder('ac');
    	/* @var $acqb \Doctrine\ORM\QueryBuilder */
    	// $acqb->select('count(ac)');
    	$acqb->where('ac.deviceId = :deviceid');
    	$acqb->andWhere('ac.username = :username');
    	
    	$date = new \DateTime();
		$date->modify('-1 hour');
		$acqb->andWhere('ac.created > :date');
		$acqb->andWhere('ac.status = 1');
		$acqb->andWhere('ac.code = :approvecode');
		$acqb->setParameter('deviceid', $deviceId);
		$acqb->setParameter('username', $username);
		$acqb->setParameter('approvecode', $approveCode);
		$acqb->setParameter('date', $date);
    	$result = $acqb->getQuery()->getResult();

    	if(count($result) > 0) {
    		$this->disableApproveCodes($deviceId, $username);
    		$em = $this->getDoctrine()->getManager();
    		$q = $em->createQuery('delete from Darkish\UserBundle\Entity\ApiToken at 
    		WHERE at.username = :username
    		');
    		$q->setParameter('username', $username);
    		$q->execute();


    		$clientRepo = $this->getDoctrine()->getRepository('DarkishUserBundle:Client');
    		$clients = $clientRepo->findBy(array('username' => $username ));
    		if(count($clients) > 0) {
    			$client = $clients[0];
    		} else {
    			$client = new \Darkish\UserBundle\Entity\Client();
    			$client->setUsername($username);
    			$em->persist($client);
    		}

    		$apiToken = new \Darkish\UserBundle\Entity\ApiToken();
    		$apiToken->setDeviceId($deviceId);
			$apiToken->setUsername($username);
			$apiToken->setCreated(new \DateTime());
			$expireDate = new \DateTime();
			$expireDate->modify('5 day');
			$apiToken->setExpire($expireDate);
			/* @var $encoderFactory \Symfony\Component\Security\Core\Encoder\EncoderFactory */
			$encrypter = $this->get('pierrre_encrypter.manager')->get('my_encrypter');
			$data = $deviceId.time().$username;
			$encryptedData = $encrypter->encrypt($data);
			$apiToken->setToken($encryptedData);
			$apiToken->setClient($client);
			$em->persist($apiToken);
			$em->flush();
			return $this->view($encryptedData , 200);

    	} else {
    		throw new HttpException(400, "Your sent approve code is invalid.");
    	}

    }


}
