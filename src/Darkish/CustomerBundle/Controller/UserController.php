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
use Darkish\CategoryBundle\Entity\DBase;
use Darkish\CategoryBundle\Entity\Estate;
use Darkish\CategoryBundle\Entity\Automobile;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;


class UserController extends Controller
{

    private $numOfItems = 3;



    /**
     * @Route("customer/ajax/assistant", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function createAssistantAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(8);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        $entity = new \Darkish\CustomerBundle\Entity\Customer();
        $entity->setType("assistant");
        $entity->setCreated(new \DateTime());
        $entity->setRecord($record);
        
        if($request->request->has('photo')) {
            $entity->setPhoto($this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->find($request->get('photo')));
        }
        $form = $this->createForm(new \Darkish\CustomerBundle\Form\CustomerPageCustomerType(), $entity);
        

        
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($entity);
        if (count($errors) > 0) {

            $errorsString = (string) $errors;

            return new JsonResponse(array('code'=>13, 'text' => $errorsString),500);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();


            if( !isset($data['isActive']) ||  $data['isActive'] == 0) {
                $entity->setIsActive(false);
            }
            
            $em->persist($entity);

            $em->flush();


            
            return new Response($this->get('jms_serializer')->serialize($entity, 'json', SerializationContext::create()->setGroups(array('customer.details',  'file.details'))));

        }

        return new Response($form->getErrors()->__toString());

        
    }



    


    /**
     * @Route("customer/ajax/assistant/all", defaults={"_format"="json"})
     */
    public function getAllAssistantAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(8);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }



        $record = $user->getRecord();

        $customersCollection = $record->getCustomers();

        $criteria = Criteria::create()
            ->where(Criteria::expr()->neq("id", $user->getId()))
        ;

        $customers = $customersCollection->matching($criteria);
        

        return new Response($this->get('jms_serializer')->serialize(array('customers' => $customers ), 'json', SerializationContext::create()->setGroups(array('customer.details', 'file.details'))));
    }


    


    /**
     * @Route("customer/ajax/assistant/get_user/{cust}", defaults={"_format"="json"})
     */
    public function getAssistant(Customer $cust) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(8);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        

        return new Response($this->get('jms_serializer')->serialize($cust, 'json', SerializationContext::create()->setGroups(array('customer.details', 'file.details'))));
    }


    

    /**
     * @Route("customer/ajax/assistant/remove/{entity}", defaults={"_format"="json"})
     * @Method({"DELETE"})
     */
    public function removeAssistant(Customer $entity) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(8);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($entity);
        $em->flush();
        return new JsonResponse(['Delete done']);
    }


    /**
     * @Route("customer/ajax/assistant/get_roles", defaults={"_format": "json"})
     * @Method({"GEt"})
     */
    public function getAccessesAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(8);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();


        $em = $this->getDoctrine()->getManager();
        return new Response($this->get('jms_serializer')->serialize($record->getAccessClass()->getCustomerRoles(), 'json',SerializationContext::create()->setGroups(array('role.list'))));
    }


    /**
     * @Route("customer/ajax/assistant/{entity}", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function updateAssistantAction(Request $request, Customer $entity) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(8);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        $entity->setType("assistant");
        
        if($request->request->has('photo')) {
            $entity->setPhoto($this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->find($request->get('photo')));
        }
        $form = $this->createForm(new \Darkish\CustomerBundle\Form\CustomerPageCustomerEditType(), $entity);
        

        
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($entity);
        if (count($errors) > 0) {

            $errorsString = (string) $errors;

            return new JsonResponse(array('code'=>13, 'text' => $errorsString),500);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $request->request->get('darkish_customerbundle_customer');

//            if($data['isActive'] == true) {
//                return new Response($data['isActive'], 500);
//            }
            if( !isset($data['isActive']) ||  $data['isActive'] == 0) {
                $entity->setIsActive(false);
            }

            
            
            $em->persist($entity);

            $em->flush();


            
            return new Response($this->get('jms_serializer')->serialize($entity, 'json', SerializationContext::create()->setGroups(array('customer.details',  'file.details'))));

        }

        return new Response($form->getErrors()->__toString());

        
    }

}
