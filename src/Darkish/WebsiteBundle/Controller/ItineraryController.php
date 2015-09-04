<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\CategoryBundle\Entity\Itinerary;
use Darkish\CategoryBundle\Entity\ManagedFile;
use Darkish\WebsiteBundle\Form\ItineraryType;
use Darkish\WebsiteBundle\Form\ManagedFileType;
use FOS\RestBundle\Controller\Annotations\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ItineraryController extends Controller
{
    /**
     * @param $forumtree
     * @Route("/itinerary", name="website_itinerary")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request) {


        $itinerary = new Itinerary();

        $form =  $this->createForm(new ItineraryType(), $itinerary);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $itineraryIterators = $itinerary->getPhotos()->getIterator();
            while($itineraryIterators->valid()) {
                $photo = $itineraryIterators->current();
                /* @var $photo \Darkish\CategoryBundle\Entity\ManagedFile */
                $photo->setUploadDir('image');
                $photo->setType('comment');
                $photo->setUserId(0);
                $photo->upload();
                $photo->setStatus(false);
                $photo->setTimestamp(new \DateTime());
                $itineraryIterators->next();
            }
            $itinerary->setCreated(new \DateTime);
            $em = $this->getDoctrine()->getManager();
            $em->persist($itinerary);
            $em->flush();
            return $this->redirect('itinerary');
        }

        $itineraries = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Itinerary')->findBy([],['id' => 'desc']);

        return $this->render('DarkishWebsiteBundle:Itinerary:index.html.twig', [
            'itineraries' => $itineraries,
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
