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


use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use JMS\Serializer\Serializer as JMSSerializer;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use Alchemy\BinaryDriver\Listeners\DebugListener;
use \GetId3\GetId3Core as GetId3;
use FFMpeg\FFProbe;
use Exception;
use Darkish\CategoryBundle\Entity\ManagedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

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


    /**
     * This method is for upload file. 
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="This is the upload file  API method",
     *  parameters={
     *      {"name"="file", "dataType"="file", "required"=true, "description"="file to upload"},
     *      {"name"="type", "dataType"="string", "required"=true, "description"="one of these :news, classified, offer, sponsor, record, operator, customer, client, store, product, database, comment"},
     *      {"name"="continual", "dataType"="integer", "required"=true, "description"="should be true"},
     *      {"name"="uploadDir", "dataType"="string", "required"=true, "description"="one of these :image, video, audio, icon, doc, banner"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      400={
     *          "Returned when the device id is not exist",
     *          "Returned when the phone is not exist",
     *          "Returned when the approve code is not exist",
     *          "Returned when the phone or device id has invalid format",
     *      },
     *      404="Returned when the approve code is invalid"
     *  }
     * )
     * @Method({"POST"})
     * @View()
     */
    public function postUploadAction(Request $request)
    {

        try {
            /* @var $form Form  */

            $file = new ManagedFile();
            $file->setStatus(0);
            $file->setTimestamp(new \DateTime());
            $file->setUserId($this->getUser()->getId());


            if($request->files->has('file')) {
                $ufile = $request->files->get('file');
                if(substr($ufile->getMimeType(), 0, 5) != 'image' && substr($ufile->getMimeType(), 0, 11) != 'application') {
                    $tmpName = time().'-'.rand(100000,999999).'.'.$ufile->getClientOriginalExtension();
                    $ufile->move('/tmp', $tmpName);
                    $ufile = new File('/tmp/'.$tmpName, true);

                    $ffprobe = FFProbe::create();


                    if($ffprobe->streams($ufile->getRealPath())->first()->isVideo()) {
                        
                        $duration = $ffprobe
                            ->format($ufile->getRealPath()) // extracts file informations
                            ->get('duration');             // returns the duration property

                        if( $duration > 600) {
                            // return new Response("طول فایل بارگذاری شده نباید بیشتر از ۵ دقیقه باشد.", 500);
                            throw new \Exception("طول فایل بارگذاری شده نباید بیشتر از ۵ دقیقه باشد.", 445);
                        }





                        
                        $ffmpeg = $this->get('dubture_ffmpeg.ffmpeg');
                        $video = $ffmpeg->open('/tmp'.'/'.$tmpName);
                        if($ffprobe->streams($ufile->getRealPath())->first()->get('width') > 480 ||
                            $ffprobe->streams($ufile->getRealPath())->first()->get('height') > 320
                        ) {
                            $video
                                ->filters()
                                ->resize(new Dimension(480, 320), ResizeFilter::RESIZEMODE_INSET)
                                ->synchronize();
                            // Start transcoding and save video
                            $newTmpName = time().'-'.rand(100000,999999).'-resized.'.$ufile->getExtension();
                            $format = new X264();
                            $format->setAudioCodec('libmp3lame');
                            if($video->save($format, '/tmp/'.$newTmpName)) {
                                $ufile = new File('/tmp/'.$newTmpName, true);
                                    
                            }    
                        }
                        

                    }

                    if($ffprobe->streams($ufile->getRealPath())->first()->isAudio()) {
                        
                        
                        $ffprobe = FFProbe::create();
                        $duration = $ffprobe
                            ->format($ufile->getRealPath()) // extracts file informations
                            ->get('duration');             // returns the duration property

                        if( $duration > 600) {
                            // return new Response(, 500);
                            throw new \Exception("طول فایل بارگذاری شده نباید بیشتر از ۱۰ دقیقه باشد.", 445);
                            
                        }



                        $ffmpeg = $this->get('dubture_ffmpeg.ffmpeg');
                        $audio = $ffmpeg->open('/tmp'.'/'.$tmpName);

                        $format = new \FFMpeg\Format\Audio\Mp3();
                        $format
                            -> setAudioChannels(2)
                            -> setAudioKiloBitrate(64);
                        $newTmpName = time().'-'.rand(100000,999999).'-resized.'.$ufile->getExtension();
                        if($audio->save($format, '/tmp/'.$newTmpName)) {
                            $ufile = new File('/tmp/'.$newTmpName, true);
                                
                        }  

                        

                    }
                }
                

                $file->setFile($ufile);
            }

            if($request->request->has('type')){
                $file->setType($request->get('type'));
            }

            if($request->request->has('entityId')){
                $file->setEntityId($request->get('entityId'));
            }
            if($request->request->has('uploadKey')) {
                $file->setUploadKey($request->get('uploadKey'));
            }

            if($request->request->has('uploadDir')){
                $file->setUploadDir($request->get('uploadDir'));
            }
            
            if($request->request->has('continual')) {
                $file->setContinual($request->get('continual'));
            } else {
                $file->setContinual(false);
            }

            $validator = $this->get('validator');
            $errors = $validator->validate($file);


            if(count($errors) == 0) {
                $em = $this->getDoctrine()->getManager();

                $file->upload();


            } else {
                $errorsString = (string) $errors;

                // return new Response($errorsString, 401);
                throw new \Exception($errorsString, 445);
                
            }

            $validator = $this->get('validator');
            $errors = $validator->validate($file);
            if(count($errors) == 0) {
                $em->persist($file);
                $em->flush();


                if($request->get('entityId')) {

                }

                $serializer = $this->get('jms_serializer');
                $serialized = $serializer->serialize($file, 'json');
    //            $serialized = $serializer->serialize($file, 'json');



                return new Response($serialized);
            } else {
                $errorsString = (string) $errors;

                // return new Response($errorsString);
                throw new \Exception($errorsString, 445);
            }

        }
        catch (\Exception $e) {
            return new Response( $e->getMessage(), 401);
        }


    }


    /**
     * This method is for assign photo to profile. 
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="This is the upload file  API method",
     *  parameters={
     *      {"name"="file_id", "dataType"="integer", "required"=true, "description"="the id for image file that uploaded befor"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      403={
     *          "Access denied"
     *      },
     *      404="Returned when the approve code is invalid"
     *  }
     * )
     * @Method({"POST"})
     * @View()
     * @Security("has_role('ROLE_USER')")
     */
    public function postProfilePhotoAction(Request $request) {

        
        /**
         * Fetching data from request and convert data to array
         */
        $data = $request->request->getIterator()->getArrayCopy();

        // create a collection of constraints
        $collectionConstraint = new Assert\Collection(array(
            'file_id'        =>  array(
                                    new Assert\NotBlank(),
                                    new Assert\Type(array('type' => 'numeric')),
                                    new Assert\Range(array('min'=> 0))
                                )
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


        $file = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->find($data['file_id']);

        if(!($file instanceof \Darkish\CategoryBundle\Entity\ManagedFile)) {
            return array('success' => false, 'errors' => 'The file id sent is not valid');   
        }

        
        $user = $this->getUser();

        $user->setPhoto($file);

        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();

        return ['code' => 200, 'message' => 'photo assigned to user profile'];
    }
    


}
