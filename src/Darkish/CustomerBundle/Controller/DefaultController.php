<?php

namespace Darkish\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\Serializer\SerializationContext;
use Darkish\CustomerBundle\Form\CustomerEditProfileType;
use Darkish\CategoryBundle\Entity\ManagedFile;
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
use Darkish\CustomerBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Darkish\CategoryBundle\Entity\Message;
use Darkish\CategoryBundle\Entity\MessageThread;
use Doctrine\Common\Collections\ArrayCollection;


class DefaultController extends Controller
{

    private $messageLoadNumber = 5;
    
    /**
     * 
     * @Route("/customer")
     * @Template("DarkishCustomerBundle:Default:index.html.php")
     */
    public function indexAction() {
        
        return array();
    }
    
    
    /**
     * @Route(
     *      "/customer/template/{name}"
     * )
     */
    public function getTemplateAction($name) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        switch ($name) {
            case 'profile.html':
                return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                break;
            
            case 'profile-edit.html':
                return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                break;

            case 'html-page.html':
                $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(2);
                if($assistantAccess->contains($role)) {
                    return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                } else {
                    throw new AccessDeniedException();
                }
                break;

            case 'messages.html':
                $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(3);
                if($assistantAccess->contains($role)) {
                    return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                } else {
                    throw new AccessDeniedException();
                }
                break;

            case 'comments.html':
                $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(4);
                if($assistantAccess->contains($role)) {
                    return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                } else {
                    throw new AccessDeniedException();
                }
                break;

            case 'attachments.html':
                $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(5);
                if($assistantAccess->contains($role)) {
                    return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                } else {
                    throw new AccessDeniedException();
                }
                break;

            case 'database.html':
                $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(6);
                if($assistantAccess->contains($role)) {
                    return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                } else {
                    throw new AccessDeniedException();
                }
                break;

            case 'store.html':
                $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
                if($assistantAccess->contains($role)) {
                    return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                } else {
                    throw new AccessDeniedException();
                }
                break;

            case 'store-product-edit.html':
                $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
                if($assistantAccess->contains($role)) {
                    return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                } else {
                    throw new AccessDeniedException();
                }
                break;
            case 'store-edit.html':
                $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
                if($assistantAccess->contains($role)) {
                    return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                } else {
                    throw new AccessDeniedException();
                }
                break;
            case 'store-create.html':
                $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
                if($assistantAccess->contains($role)) {
                    return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                } else {
                    throw new AccessDeniedException();
                }
                break;
            case 'users.html':
                $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(8);
                if($assistantAccess->contains($role)) {
                    return $this->render('DarkishCustomerBundle:Default:Templates/'.$name.'.php');
                } else {
                    throw new AccessDeniedException();
                }
                break;

            default:
                # code...
                break;
        }

        
    }


    /**
     * @Route("customer/get_user",
     *      defaults={"_format" = "json"})
     * @Method({"GET"})
     */
    public function getUserAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        $serialized = $this->get('jms_serializer')->serialize($user, 'json', 
            SerializationContext::create()->setGroups(array('customer.details')));
        return new Response($serialized);
    }

    /**
     * @Route("customer/ajax/get_message_threads", defaults={"_format" = "json"})
     * @Method({"GET"})
     */
    public function getMessageThreads() {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(3);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }
        // $threads = $this->getDoctrine()->getRepository('DarkishCategoryBundle:MessageThread')->findBy(array('record'=>$user->getRecord()->getId()));
        // $qb =  $this->getDoctrine()
        //             ->getRepository('DarkishCategoryBundle:MessageThread')
        //             ->createQueryBuilder('th');
        // $qb->where('th.record = :rid')->setParameter('rid', $user->getRecord()->getId());
        // $threads = $qb->getQuery()->getResult();
        // 
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT th from \Darkish\CategoryBundle\Entity\MessageThread th 
            WHERE th.record = :rid AND  th.deletedByRecord = 0");
        $query->setParameter('rid', $user->getRecord()->getId());
        $threads = $query->getResult();
        $oldLastMessageId = $user->getRecord()->getLastMessageRecieve();
        $lastMessageId = 0;
        foreach($threads as $thread) {
            $lastMessageId = ($thread->getLastMessage()->getId() > $lastMessageId) ? $thread->getLastMessage()->getId() : $lastMessageId;
        }

        $user->getRecord()->setLastMessageRecieve($lastMessageId);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user->getRecord());
        $em->flush();

        return new Response($this->get('jms_serializer')->serialize(
            array('threads' => $threads, 'last_message' => $oldLastMessageId)
            , 'json'
            ,SerializationContext::create()->setGroups(array('thread.list'))
        ));
    }

    /**
     * @Route("customer/ajax/get_messages_for_thread/{thread}/{lastMessage}", 
     *         defaults={"lastMessage" = 0, "_format": "json"})
     * @Method({"GET"})
     */
    public function getMessagesForThreadAction(\Darkish\CategoryBundle\Entity\MessageThread $thread, $lastMessage) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(3);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }
        if($thread->getRecord()->getId() != $user->getRecord()->getId()) {
            throw new AccessDeniedException();   
        }

        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Message');
        $qb = $repo->createQueryBuilder('m');
        $qb->where('m.thread = :thid')->setParameter('thid', $thread->getId());
        $qb->andWhere('m.deletedByRecord = :f')->setParameter('f', false);
        if($lastMessage) {
            // $qb->where('m.id < :lastMessage')->setParameter('lastMessage', $lastMessage);
            $qb->setFirstResult($lastMessage);
        }
        $qb->setMaxResults($this->messageLoadNumber);
        $qb->orderBy('m.created', 'DESC');
        $qb->orderBy('m.id', 'DESC');

        $res = $qb->getQuery()->getResult();



        $serialized = $this->get('jms_serializer')->serialize($res, 'json'
            ,SerializationContext::create()->setGroups(array('thread.list')));

        return new Response($serialized);
        

    }

    /**
     * @Route("customer/ajax/post_message/{thread}")
     * @Method({"PUT"})
     */
    public function submitMessage(\Darkish\CategoryBundle\Entity\MessageThread $thread, Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(3);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }
        if($thread->getRecord()->getId() != $user->getRecord()->getId()) {
            throw new AccessDeniedException();   
        }
        
        $em = $this->getDoctrine()->getManager();
        $msg = new \Darkish\CategoryBundle\Entity\Message();
        $msg->setCreated(new \DateTime());
        $msg->setThread($thread);
        $msg->setFrom('record');
        $msg->setText($request->get('text'));

        $em->persist($msg);

        $em->flush();

        $serialized = $this->get('jms_serializer')->serialize($msg, 'json'
            ,SerializationContext::create()->setGroups(array('thread.list')));

        return new Response($serialized);
    }


    /**
     * @Route("customer/ajax/post_group_message", defaults={"_format" = "json"})
     * @Method({"POST"})
     */
    public function submitGroupMessage(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(3);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }
        
        $em = $this->getDoctrine()->getManager();
        $thread = new \Darkish\CategoryBundle\Entity\GroupMessageThread();

        $message = new \Darkish\CategoryBundle\Entity\Message();
        $message->setCreated(new \DateTime());
        $message->setThread($thread);
        $message->setFrom('record');
        $message->setText($request->get('text'));

        $clients = $user->getRecord()->getClientsFavorited();

        $thread->setRecord($user->getRecord());
        $thread->setLastMessage($message);

        $clientsIterator = $clients->getIterator();
        while($clientsIterator->valid()) {
            $thread->addClient($clientsIterator->current());
            $clientsIterator->next();
        }

        $em->persist($thread);
        $em->persist($message);

        $em->flush();

        return new Response($this->get('jms_serializer')->serialize($thread, 'json'
            ,SerializationContext::create()->setGroups(array('thread.details'))));
        

    }

    /**
     * @Route("/customer/ajax/set_last_delivered/{thread}/{message}")
     * @Method({"PUT"})
     */
    public function setLastDelivered(MessageThread $thread, $message, Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(3);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }
        $data = $request->get('data');
        $em = $this->getDoctrine()->getManager();
        $thread->setLastRecordDelivered($message);
        $em->persist($thread);
        $em->flush();
        return new Response($this->get('jms_serializer')->serialize(array('done'), 'json'));

    }


    /**
     * @Route("/customer/ajax/set_last_seen/{thread}/{message}")
     * @Method({"PUT"})
     */
    public function setLastSeen(MessageThread $thread, $message, Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(3);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }
        $data = $request->get('data');
        $em = $this->getDoctrine()->getManager();
        $thread->setLastRecordSeen($message);
        $em->persist($thread);
        $em->flush();
        return new Response($this->get('jms_serializer')->serialize(array('done'), 'json'));

    }

    /**
     * @Route("/customer/ajax/set_last_client_delivered/{thread}/{message}")
     * @Method({"PUT"})
     */
    public function setLastClientDelivered(MessageThread $thread, $message, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $thread->setLastClientDelivered($message);
        $em->persist($thread);
        $em->flush();
        return new Response($this->get('jms_serializer')->serialize(array('done'), 'json'));
    }

    /**
     * @Route("/customer/ajax/set_last_client_seen/{thread}/{message}")
     * @Method({"PUT"})
     */
    public function setLastClientSeen(MessageThread $thread, $message, Request $request) {
        $em = $this->getDoctrine()->getManager();
        $thread->setLastClientSeen($message);
        $em->persist($thread);
        $em->flush();
        return new Response($this->get('jms_serializer')->serialize(array('done'), 'json'));
    }


    /**
     * @Route("/customer/ajax/fetch_last_seen_delivered/{thread}", defaults={"_foramt" = "json"})
     * @Method({"GET"})
     */
    public function fetchLastSeenDelivered(MessageThread $thread) {
        return new Response($this->get('jms_serializer')->serialize(
            array(
                'seen' => $thread->getLastClientSeen(),
                'delivered' => $thread->getLastClientDelivered()
            ),
         'json'));
    }

    /**
     * @Route("customer/ajax/manual/post_message/{client}/{record}", defaults={"_format" = "json"})
     * @Method({"PUT"})
     */
    public function submitManualMessage(\Darkish\UserBundle\Entity\Client $client, \Darkish\CategoryBundle\Entity\Record $record, Request $request) {
        $em = $this->getDoctrine()->getManager();
        
        $qb = $this->getDoctrine()
                   ->getRepository('DarkishCategoryBundle:PrivateMessageThread')
                   ->createQueryBuilder('pmt');

        $qb->where('pmt.client = :clid')->setParameter('clid', $client->getId());
        $qb->andWhere('pmt.record = :rid')->setParameter('rid', $record->getId());

        $qb->setMaxResults(1);
        $res = $qb->getQuery()->getResult();
        
        // return new Response($this->get('jms_serializer')->serialize($res, 'json'
        //     ,SerializationContext::create()->setGroups(array('thread.details'))));

        if(count($res)){
            $thread = $res[0];
            $thread->setDeletedByRecord(false);
            $thread->setDeletedByClient(false);
        } else{
            $thread = new \Darkish\CategoryBundle\Entity\PrivateMessageThread();
            $thread->setRecord($record);
            $thread->setClient($client);
        
        }

        $message = new \Darkish\CategoryBundle\Entity\Message();
        $message->setCreated(new \DateTime());
        $message->setThread($thread);
        $message->setFrom('client');
        $message->setText($request->get('text'));

        $thread->setLastMessage($message);

        $em->persist($thread);
        $em->persist($message);

        $em->flush();

        return new Response($this->get('jms_serializer')->serialize($thread, 'json'
            ,SerializationContext::create()->setGroups(array('thread.details'))));
        
    }

    /**
     * @Route("customer/ajax/refresh_messages/{last}")
     */
    public function refreshMessages($last) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(3);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $qb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Message')
                   ->createQueryBuilder('m');
        $qb->join('m.thread', 'th');
        $qb->join('th.record', 'r', 'WITH', 'r.id = :rid')
           ->setParameter('rid', $user->getRecord()->getId());
        $qb->where('m.id > :last')->setParameter('last', $last);
        $qb->andWhere('th.deletedByRecord = :f')->setParameter('f', false);
        $qb->andWhere('m.deletedByRecord = :f')->setParameter('f', false);

        $res = $qb->getQuery()->getResult();

        return new Response($this->get('jms_serializer')->serialize($res, 'json'
            ,SerializationContext::create()->setGroups(array('message.list', 'thread.list'))));

    }

    /**
     * @Route("customer/ajax/delete/{thread}", defaults={"_format" = "json"})
     * @Method({"DELETE"})
     */
    public function deleteThread(MessageThread $thread) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(3);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }
        if($thread->getRecord()->getId() != $user->getRecord()->getId()) {
            throw new AccessDeniedException();   
        }

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            "UPDATE \Darkish\CategoryBundle\Entity\Message m SET m.deletedByRecord = 1 WHERE m.thread = :thid"
        );
        $query->setParameter('thid', $thread->getId());

        $query->execute();

        $thread->setDeletedByRecord(true);
        $em->persist($thread);
        $em->flush();

        return new JsonResponse(array('Done'));

    }


    /**
     * 
     * @Route("customer/ajax/update/{customer}",defaults={"_format": "json"} )
     * @Method({"POST"})
     * @Security("is_granted('edit', customer)")
     */
    public function updateAction(Request $request, Customer $customer) {
        // return new Response($this->get('jms_serializer')->serialize($id->getId(), 'json'));
        // die('asd');
        $em = $this->getDoctrine()->getManager();
        // $customer = $em->getRepository('DarkishCustomerBundle:Customer')->find($id);
//        return new Response($this->get('jms_serializer')->serialize($request->request, 'json'));
        $form = $this->createForm(new CustomerEditProfileType, $customer);
        $photoId = $request->request->get('customer_edit_profile[photo]', null, true);
        $darkish_userbundle_operator = $request->request->get('customer_edit_profile');
        unset($darkish_userbundle_operator['photo']);
        $request->request->set('customer_edit_profile', $darkish_userbundle_operator);
        $form->handleRequest($request);
        if ($form->isValid()) {
            if($photoId) {
                $photo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->find($photoId);
                $customer->setPhoto($photo);
                $em->persist($customer);
            }
            // perform some action, such as saving the task to the database
            $em->flush();
            return new Response($this->get('jms_serializer')->serialize($customer, 'json', SerializationContext::create()->setGroups(array('customer.details'))));
        }
        return new Response($form->getErrorsAsString(), 500);
    }



    /**
     * @Route("/customer/ajax/upload",defaults={"_format": "json"})
     * @Method({"POST"})
     */
    public function uploadAction(Request $request)
    {

        try {
            /* @var $form Form  */

            $file = new ManagedFile();
            $file->setStatus(0);
            $file->setTimestamp(new \DateTime());
            $file->setUserId($this->getUser()->getId());


            if($request->files->has('file')) {
                $ufile = $request->files->get('file');
                
                if(substr($ufile->getMimeType(), 0, 5) != 'image') {
                    $tmpName = time().'-'.rand(100000,999999).'.'.$ufile->getClientOriginalExtension();
                    $ufile->move('/tmp', $tmpName);
                    $ufile = new File('/tmp/'.$tmpName, true);

                    $ffprobe = FFProbe::create();


                    if($ffprobe->streams($ufile->getRealPath())->first()->isVideo()) {
                        
                        $duration = $ffprobe
                            ->format($ufile->getRealPath()) // extracts file informations
                            ->get('duration');             // returns the duration property

                        if( $duration > 300) {
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
     * @Route("customer/ajax/get_store_data", defaults={"_format" = "json"})
     * @Method({"GET"})
     */
    public function getStoreData() {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        $storeData = array();
        $storeData['market_description'] = $record->getMarketDescription();
        $storeData['market_banner'] = $record->getMarketBanner();
        $storeData['market_template'] = $record->getMarketTemplate();
        $storeData['market_groups'] = $record->getMarketGroups();


        return new Response($this->get('jms_serializer')->serialize($storeData, 'json', SerializationContext::create()->setGroups(array('record.store'))));
    }

    /**
     * @Route("customer/ajax/get_templates", defaults={"_format" = "json"})
     */
    public function getTemplates() {
        $templates = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Template')->findAll();
        return new Response($this->get('jms_serializer')->serialize($templates, 'json', SerializationContext::create()->setGroups(array('template.details'))));
    }


    /**
     * @Route("customer/ajax/save_store_details", defaults={"_format" = "json"})
     * @Method({"POST"})
     */
    public function saveStoreDetails(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $record = $user->getRecord();

        if($request->get('description')) {
            $record->setMarketDescription($request->get('description'));    
        }
        if($request->get('banner')) {
            $bannerReq = $request->get('banner');
            $banner = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->find($bannerReq['id']);
            if(!$banner) {
                throw new \Exception("Banner is not valid", 404);
            }
            $record->setMarketBanner($banner);
        }

        if($request->get('template')) {
            $templateReq = $request->get('template');
            $template = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Template')->find($templateReq['id']);
            if(!$template) {
                throw new \Exception("Template is not valid", 404);
            }
            $record->setMarketTemplate($template);   
        }

        if($request->get('groups')) {
            $groupsReq = $request->get('groups');
            $currentGroups = $record->getMarketGroups();
            if($currentGroups) {
                $newGroups = new ArrayCollection();
                $eCollec = new ArrayCollection();
                $neCollec = new ArrayCollection();
                $remainCollec = new ArrayCollection();
                
                foreach ($groupsReq as $key => $value) {
                    if(isset($value['id'])) {
                        $group = $this->getDoctrine()->getRepository('DarkishCategoryBundle:StoreGroup')->find($value['id']);
                        $newGroups->add($group);
                        $eCollec->add($group);
                    } else {
                        $group = new \Darkish\CategoryBundle\Entity\StoreGroup();
                        $group->setName($value['name']);
                        $group->setRecord($record);
                        $em->persist($group);
                        $newGroups->add($group);
                        $neCollec->add($group);
                    }
                }

                $currentGroupsIterator = $currentGroups->getIterator();
                while($currentGroupsIterator->valid()) {
                    if(!$eCollec->contains($currentGroupsIterator->current())) {
                        $currentGroups->removeElement($currentGroupsIterator->current());
                        $em->remove($currentGroupsIterator->current());
                    }
                    $currentGroupsIterator->next();
                }

                $neCollecIterator = $neCollec->getIterator();
                while($neCollecIterator->valid()) {
                    $currentGroups->add($neCollecIterator->current());
                    $neCollecIterator->next();
                }

            }



            
        }

        $em = $this->getDoctrine()->getManager();
        $em->persist($record);
        $em->flush();
        
        $storeData['market_description'] = $record->getMarketDescription();
        $storeData['market_banner'] = $record->getMarketBanner();
        $storeData['market_template'] = $record->getMarketTemplate();
        $storeData['market_groups'] = $record->getMarketGroups();

        return new Response($this->get('jms_serializer')->serialize($storeData, 'json', SerializationContext::create()->setGroups(array('record.store'))));

    }
}
