<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\CategoryBundle\Entity\Estate;
use Darkish\WebsiteBundle\Form\AutomobileSearchType;
use Darkish\WebsiteBundle\Form\EstateSearchType;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\Animation;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Length;
use Darkish\CustomerBundle\Entity\Customer;
use Darkish\CategoryBundle\Entity\Record;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zend\I18n\Validator\DateTime;

/**
 * @Route("/", host="%domain%")
 */
class RecordController extends Controller
{
	/**
	 * @Route("/record", name="website_record")
	 */
    public function indexAction()
    {
    	$breadcrumbs = $this->get("white_october_breadcrumbs");
	    // Simple example
	    $breadcrumbs->addItem("خانه", $this->get("router")->generate("website_home"));
		// Example without URL
	    $breadcrumbs->addItem('رکوردها');

    	$trees = $this->getDoctrine()->getRepository('DarkishWebsiteBundle:WebMainTree')->getSubTrees();
    	return $this->render('DarkishWebsiteBundle:Record:index.html.twig', ['trees' => $trees]);
    }


    /**
	 * @Route("/record/tree/{treeIndex}", name="website_record_tree")
	 */
    public function recordTreeAction($treeIndex, Request $request)
    {
        $tree = $this->getDoctrine()->getRepository('DarkishWebsiteBundle:WebMainTree')->findOneBy(['treeIndex' => $treeIndex]);
        $trees = $this->getDoctrine()->getRepository('DarkishWebsiteBundle:WebMainTree')->getSubTrees($treeIndex);
        if (!$tree) {
            throw new NotFoundHttpException("TreeIndex NotFound");
        }
        if ($request->query->has('centers'))
        {
            $centers = $request->query->get('centers');
        } else {
            $centers = [];
        }
//        return new Response($this->get('jms_serializer')->serialize($centers, 'json'));

    	
    	$breadcrumbs = $this->get("white_october_breadcrumbs");
	    // Simple example
	    $breadcrumbs->addItem("خانه", $this->get("router")->generate("website_home"));
		// Example without URL
	    $breadcrumbs->addItem("رکوردها", $this->get("router")->generate("website_record"));

	    $breadcrumbs->addItem($tree->getTitle());



    	$newsQb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->getRecordsForTreeIds($tree->getTreesIds(), $centers);


    	$paginator  = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
	        $newsQb->getQuery(),
	        (int)$request->get('page', 1)/*page number*/,
	        10/*limit per page*/
	    );

    	return $this->render('DarkishWebsiteBundle:Record:record-tree.html.twig', 
				[
					'tree'  => $tree,
					'trees' => $trees,
					'pagination' => $pagination
				]
			);


    }



    /**
     * @Route("/record/{record}", name="website_record_single")
     */
    public function recordAction($record) {



        $record = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')
            ->findOneBy(['recordNumber' => $record]);

        if(!$record)
        {
            throw new NotFoundHttpException("The recordNumber is invalid");
        }

        $this->get('darkish_website.breadcrumb_manager')->createBreadcrumb('website_record_single', $record);

//    	$breadcrumbs = $this->get("white_october_breadcrumbs");
//	    // Simple example
//	    $breadcrumbs->addItem("خانه", $this->get("router")->generate("website_home"));
//		// Example without URL
//	    $breadcrumbs->addItem("رکوردها", $this->get("router")->generate("website_record"));
//
//	    $breadcrumbs->addItem($record->getTitle());

	    // Example with parameter injected into translation "user.profile"
	    // $breadcrumbs->addItem($txt, $url, ["%user%" => $user->getName()]);

		$products = $this->getDoctrine()
						  	->getRepository('DarkishCategoryBundle:Record')
							->getStoreInfo($record, $this->get('jms_serializer'));

        $record->setVisitCount($record->getVisitCount() + 1);
        $em = $this->getDoctrine()->getManager();
        $em->persist($record);
        $em->flush();

//		$map = $this->get('ivory_google_map.map');
//		$map->setAutoZoom(false);
//		$map->setCenter($record->getLatitude(), $record->getLongitude(), true);
//		$map->setMapOption('zoom', 16);
//
//		$map->setStylesheetOptions(array(
//			'width'  => '100%',
//			'height' => '500px',
//		));
//
//		$marker = new Marker();
//
//// Configure your marker options
//		$marker->setPrefixJavascriptVariable('marker_');
//		$marker->setPosition($record->getLatitude(), $record->getLongitude(), true);
//		$marker->setAnimation(Animation::DROP);
//
//		$marker->setOption('clickable', false);
//		$marker->setOption('flat', true);
//		$marker->setOptions(array(
//			'clickable' => false,
//			'flat'      => true,
//		));
//		$map->addMarker($marker);

    	return $this->render('DarkishWebsiteBundle:Record:record.html.twig', ['record' => $record, 'products' => $products]);
    }

	/**
	 * @Route("test_image")
	 */
	public function testAction() {

		$file = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->find(35836);

		$file->setDarkishWatermark(true);
		$file->setIslandWatermark(true);
		$file->setArunaWatermark(false);

		$em = $this->getDoctrine()->getManager();
		$em->persist($file);
		$em->flush();
		return new Response('done');
	}




}
