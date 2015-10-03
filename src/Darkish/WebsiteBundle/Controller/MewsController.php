<?php

namespace Darkish\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Length;
use Darkish\CustomerBundle\Entity\Customer;
use Darkish\CategoryBundle\Entity\News;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/", host="%news_subdomain%")
 */
class MewsController extends Controller
{
	/**
	 * @Route("/", name="website_news")
	 */
    public function indexAction()
    {

    	$breadcrumbs = $this->get("white_october_breadcrumbs");
	    // Simple example
	    $breadcrumbs->addItem("خانه", $this->get("router")->generate("website_home"));
		// Example without URL
	    $breadcrumbs->addItem('اخبار');


    	$trees = $this->getDoctrine()->getRepository('DarkishCategoryBundle:NewsTree')->getSubTrees("##");
    	return $this->render('DarkishWebsiteBundle:News:index.html.twig', ['trees' => $trees]);
    }


    /**
	 * @Route("/tree/{treeIndex}/{page}", name="website_news_tree", defaults={"page" = 1})
	 */
    public function newsTreeAction($treeIndex, $page = 1, Request $request)
    {
    	$tree = $this->getDoctrine()->getRepository('DarkishCategoryBundle:NewsTree')->findOneBy(['treeIndex' => $treeIndex]);
    	$trees = $this->getDoctrine()->getRepository('DarkishCategoryBundle:NewsTree')->getSubTrees($treeIndex);
    	if(!$tree) {
    		throw new NotFoundHttpException("TreeIndex NotFound");
    		
    	}

    	
    	$breadcrumbs = $this->get("white_october_breadcrumbs");
	    // Simple example
	    $breadcrumbs->addItem("خانه", $this->get("router")->generate("website_home"));
		// Example without URL
	    $breadcrumbs->addItem("خبر", $this->get("router")->generate("website_news"));

	    $breadcrumbs->addItem($tree->getTitle());



    	$newsQb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News')->getNewsForCat($tree);

    	$paginator  = $this->get('knp_paginator');
    	$pagination = $paginator->paginate(
	        $newsQb->getQuery(),
	        (int)$request->get('page', 1)/*page number*/,
	        10/*limit per page*/
	    );

    	return $this->render('DarkishWebsiteBundle:News:news-tree.html.twig', 
				[
					'tree'  => $tree,
					'trees' => $trees,
					'pagination' => $pagination
				]
			);


    }



    /**
     * @Route("/{news}", name="website_news_single")
     */
    public function newsAction(News $news) {

    	$breadcrumbs = $this->get("white_october_breadcrumbs");
	    // Simple example
	    $breadcrumbs->addItem("خانه", $this->get("router")->generate("website_home"));
		// Example without URL
	    $breadcrumbs->addItem("خبر", $this->get("router")->generate("website_news"));

	    $breadcrumbs->addItem($news->getTitle());

	    // Example with parameter injected into translation "user.profile"
	    // $breadcrumbs->addItem($txt, $url, ["%user%" => $user->getName()]);

    	return $this->render('DarkishWebsiteBundle:News:news.html.twig', ['news' => $news]);
    }


}
