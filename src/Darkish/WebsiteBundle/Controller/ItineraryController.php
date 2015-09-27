<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\CategoryBundle\Entity\AnonymousItinerary;
use Darkish\CategoryBundle\Entity\Itinerary;
use Darkish\CategoryBundle\Entity\ManagedFile;
use Darkish\WebsiteBundle\Form\ItineraryType;
use Darkish\WebsiteBundle\Form\ManagedFileType;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/", host="%domain%")
 */
class ItineraryController extends Controller
{
    /**
     * @param $forumtree
     * @Route("/itinerary", name="website_itinerary")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request) {


        $itinerary = new AnonymousItinerary();

        $form =  $this->createForm(new ItineraryType(), $itinerary);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $itineraryIterators = $itinerary->getPhotos()->getIterator();
            while($itineraryIterators->valid()) {
                $photo = $itineraryIterators->current();
                $photo->setUserId(0);
                $photo->setOneup(true);
                /* @var $photo \Darkish\CategoryBundle\Entity\ManagedFile */
                $itineraryIterators->next();
            }
            $itinerary->setCreated(new \DateTime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($itinerary);
            $em->flush();
            return $this->redirect('itinerary');
        }

        $qb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Itinerary')->createQueryBuilder('it');
        $qb->orderBy('it.id', 'desc');


        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $qb->getQuery(),
            (int)$request->get('page', 1)/*page number*/,
            5/*limit per page*/
        );

        return $this->render('DarkishWebsiteBundle:Itinerary:index.html.twig', [
            'paginator' => $paginator,
            'form' => $form->createView()
        ]);


    }

    /**
     * @param Itinerary $itinerary
     * @Route("itinerary/get_comments/{itinerary}", name="website_itinerary_get_comments", options={"expose"=true})
     */
    public function getComments(Itinerary $itinerary)
    {
        return $this->render('@DarkishWebsite/Itinerary/get-comments.html.twig', [
            'itinerary' => $itinerary
        ]);
    }

}
