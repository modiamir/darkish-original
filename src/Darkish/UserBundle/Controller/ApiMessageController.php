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
class ApiMessageController extends FOSRestController
{
    /**
     * This method is for refresh messages to get new messages. 
     * 
     * @ApiDoc(
     *  resource=true,
     *  description="This is for refresh messages to get new messages.",
     *  statusCodes={
     *      200="Returned when successful",
     *      500="Returned when the approve code is invalid"
     *  }
     * )
     * 
     * @View()
     */
    public function getNewAction($lastMessageId) {
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

    
    /**
     * @ApiDoc(
     *  resource=true,
     *  description="This is for posting new message to record",
     *  parameters={
     *      {"name"="text", "dataType"="string", "required"=true, "description"="message text"}
     *  },
     *  statusCodes={
     *      200="Returned when successful",
     *      500="Returned when the user is not capable to send request because of his multiple request in last hour",
     *      404="Returned when the record id is not valid"
     *  }
     * )
     */
    public function postAction(\Darkish\CategoryBundle\Entity\Record $record, Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        
        
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

}
