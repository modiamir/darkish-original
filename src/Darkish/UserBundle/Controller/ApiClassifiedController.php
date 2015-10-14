<?php

namespace Darkish\UserBundle\Controller;

use Darkish\CategoryBundle\Entity\ClientClassified;
use Darkish\CategoryBundle\Entity\ClientItinerary;
use Darkish\UserBundle\Form\ItineraryType;
use Darkish\WebsiteBundle\Form\ClassifiedType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
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
use Darkish\CategoryBundle\Entity\Itinerary;
use FOS\RestBundle\Controller\Annotations as RouteAnnot;



/**
 * 
 */
class ApiClassifiedController extends FOSRestController
{

    /**
     * @ApiDoc(
     *  resource=true,
     *  section="Itinerary API"
     * )
     * @RouteAnnot\Get("get_itineraries/{count}/{page}", defaults={"_format"="json"})
     * @View(serializerGroups={"itinerary.list.api"})
     */
//    public function getItinerariesAction($count = 3, $page = 1, Request $request) {
//
//        $em    = $this->get('doctrine.orm.entity_manager');
//        $dql   = "SELECT a FROM DarkishCategoryBundle:Itinerary a";
//        $query = $em->createQuery($dql);
//
//        /* @var $paginator \Knp\Component\Pager\Paginator */
//        $paginator  = $this->get('knp_paginator');
//        /* @var $pagination \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination */
//        $pagination = $paginator->paginate(
//            $query,
//            $page/*page number*/,
//            $count/*count*/
//        );
//
//        // parameters to template
//        return $pagination->getItems();
//    }

    /**
     * @ApiDoc(
     *  resource=true,
     *  section="Classified API",
     *  input="Darkish\WebsiteBundle\Form\ClassifiedType"
     * )
     * @RouteAnnot\Post("create_classified", defaults={"_format"="json"})
     * @View(serializerGroups={"classified.details", "file.details"})
     * @Security(expression="has_role('ROLE_USER')")
     */
    public function postClassifiedAction(Request $request)
    {

        $client = $this->getUser();

        $classified = new ClientClassified();

        $form =  $this->createForm(new ClassifiedType(), $classified);
        $form->handleRequest($request);
        $validation = $this->get('validator')->validate($classified);
        if($validation->count())
        {
            $errors = array();
            foreach ($validation as $error) {
                // getPropertyPath returns form [email], so we strip it
                $field = $error->getPropertyPath();
                $errors[$field] = $error->getMessage();
            }
            return array('success' => false, 'errors' => $errors);
        }

        if($form->isSubmitted() && $form->isValid())
        {
//            $itineraryIterators = $itinerary->getPhotos()->getIterator();
//            while($itineraryIterators->valid()) {
//                $photo = $itineraryIterators->current();
//                $photo->setUserId(0);
//                $photo->setOneup(true);
//                /* @var $photo \Darkish\CategoryBundle\Entity\ManagedFile */
//                $itineraryIterators->next();
//            }
            $classified->setCreationDate(new \DateTime);
            $classified->setClient($client);
            $em = $this->getDoctrine()->getManager();
            $em->persist($classified);
            $em->flush();
            return $classified;
        }

        return $form->getErrors()->__toString();
    }


    /**
     * @ApiDoc(
     *  resource=true,
     *  section="Itinerary API"
     * )
     * @RouteAnnot\Get("get_itinerary/{itinerary}", defaults={"_format"="json"})
     * @View(serializerGroups={"itinerary.list.api"})
     */
//    public function getItineraryAction(Itinerary $itinerary) {
//
//        return $itinerary;
//    }

}
