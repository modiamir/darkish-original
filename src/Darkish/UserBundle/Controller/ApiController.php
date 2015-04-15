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


/**
 * 
 */
class ApiController extends FOSRestController
{
    /**
     *
     * @ApiDoc(
     *  description="Get time request",
     *  resource="User",
     *  statusCodes={
     *      200="Returned when user is logged in",
     *      401="Returned when the user is not logged in",
     *      403="Returned when the user apikey is invalid"
     *  }
     * 
     * )
     * 
     * @View()
     */
    public function getTimeAction()
    {
    	$user = $this->get('security.context')->getToken()->getUser();
    	date_default_timezone_set('Asia/Tehran');
    	$date = date('m/d/Y h:i:s a', time());
    	if($user instanceof \Darkish\UserBundle\Entity\Client) {
    		return $this->view($date, 200);
    	} 
    	return $this->view($date, 401);

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
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403="Returned when the user is not capable to send request because of his multiple request in last hour",
     *      400={
     *          "Returned when the device id is not exist",
     *      	"Returned when the phone is not exist",
     *       	"Returned when the phone or device id has invalid format",
     *  	}
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
    	// return $this->view("The approve code created and sent you via sms. (This is code: $code )", 200);
    	return $this->view($code, 200);
    	
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
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400={
     *          "Returned when the device id is not exist",
     *      	"Returned when the phone is not exist",
     *       	"Returned when the approve code is not exist",
     *       	"Returned when the phone or device id has invalid format",
     *  	},
     *   	404="Returned when the approve code is invalid"
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
    		WHERE at.username = :username OR at.deviceId = :deviceid
    		');
    		$q->setParameter('username', $username);
    		$q->setParameter('deviceid', $deviceId);
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
    		throw new HttpException(404, "Your sent approve code is invalid.");
    	}

    }


    public function getNewMessagesAction($lastMessageId) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        
        // $qb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Message')
        //            ->createQueryBuilder('m');
        //            
        $em = $this->getDoctrine()->getManager();

        $privateThreadQuery = $em->createQuery(
            "SELECT pmth.id from \Darkish\CategoryBundle\Entity\PrivateMessageThread pmth 
                join pmth.client c where c.id = :cid
            ");
        $privateThreadQuery->setParameter('cid', $user->getId());


        $groupThreadQuery = $em->createQuery(
            "SELECT pmth.id from \Darkish\CategoryBundle\Entity\GroupMessageThread pmth 
                join pmth.clients c where c.id = :cid
            ");
        $groupThreadQuery->setParameter('cid', $user->getId());
        // $query = $em->createQuery(
        //     "SELECT m FROM \Darkish\CategoryBundle\Entity\Message m join m.thread th 
        //         where th INSTANCE OF \Darkish\CategoryBundle\Entity\PrivateMessageThread && th.client"
        // );
        

        $privateThreads = $privateThreadQuery->getResult();
        $privateThreasIds = array();
        foreach ($privateThreads as $key => $value) {
            $privateThreasIds[] = $value['id'];
        }


        $groupThreads = $groupThreadQuery->getResult();
        $groupThreasIds = array();
        foreach ($groupThreads as $key => $value) {
            $groupThreasIds[] = $value['id'];
        }


        $threadsIds = array_merge($groupThreasIds, $privateThreasIds);


        $messagesQuery = $em->createQuery("SELECT m from \Darkish\CategoryBundle\Entity\Message m join m.thread th where th.id in (:thids) and m.id > :last");
        $messagesQuery->setParameter('thids', $threadsIds);
        $messagesQuery->setParameter('last', $lastMessageId);

        $messages = $messagesQuery->getResult();

        
        return new Response($this->get('jms_serializer')->serialize($messages, 'json'
            ,SerializationContext::create()->setGroups(array('message.list', 'thread.list', 'file.details'))));
    }


}
