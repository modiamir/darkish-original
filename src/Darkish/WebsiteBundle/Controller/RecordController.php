<?php

namespace Darkish\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Length;
use Darkish\CustomerBundle\Entity\Customer;
use Darkish\CategoryBundle\Entity\Record;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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


    	$trees = $this->getDoctrine()->getRepository('DarkishCategoryBundle:MainTree')->getSubTrees();
    	return $this->render('DarkishWebsiteBundle:Record:index.html.twig', ['trees' => $trees]);
    }


    /**
	 * @Route("/record/tree/{treeIndex}/{page}", name="website_record_tree", defaults={"page" = 1})
	 */
    public function recordTreeAction($treeIndex, $page = 1, Request $request)
    {
    	$tree = $this->getDoctrine()->getRepository('DarkishCategoryBundle:MainTree')->findOneBy(['treeIndex' => $treeIndex]);
    	$trees = $this->getDoctrine()->getRepository('DarkishCategoryBundle:MainTree')->getSubTrees($treeIndex);
    	if(!$tree) {
    		throw new NotFoundHttpException("TreeIndex NotFound");
    		
    	}


    	
    	$breadcrumbs = $this->get("white_october_breadcrumbs");
	    // Simple example
	    $breadcrumbs->addItem("خانه", $this->get("router")->generate("website_home"));
		// Example without URL
	    $breadcrumbs->addItem("رکوردها", $this->get("router")->generate("website_record"));

	    $breadcrumbs->addItem($tree->getTitle());



    	$newsQb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->getRecordsForCat($tree);


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
    public function recordAction(Record $record) {

    	$breadcrumbs = $this->get("white_october_breadcrumbs");
	    // Simple example
	    $breadcrumbs->addItem("خانه", $this->get("router")->generate("website_home"));
		// Example without URL
	    $breadcrumbs->addItem("خبر", $this->get("router")->generate("website_news"));

	    $breadcrumbs->addItem($record->getTitle());

	    // Example with parameter injected into translation "user.profile"
	    // $breadcrumbs->addItem($txt, $url, ["%user%" => $user->getName()]);

    	return $this->render('DarkishWebsiteBundle:Record:record.html.twig', ['record' => $record]);
    }


}
