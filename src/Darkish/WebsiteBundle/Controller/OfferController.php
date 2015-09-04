<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree;
use Darkish\CategoryBundle\Entity\OfferOfferTree;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Faker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OfferController extends Controller
{
    /**
     * @Route("offer", name="website_offer", options={"expose"=true})
     */
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Offer');

        $qb = $repo->createQueryBuilder('o');

        $treeRepo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:OfferTree');
        $upTrees = $treeRepo->findBy(['upTreeIndex'=>'00']);


        $offerTree = null;
        if($request->query->has('tree'))
        {
            $offerTree = $treeRepo->findOneBy(['treeIndex' => $request->query->get('tree')]);
            $qb->join('o.offertrees', 'ot', 'WITH');
            $qb->join('ot.tree', 'ott', 'WITH', 'ott.treeIndex = :tree')->setParameter('tree', $request->query->get('tree'));

        }
        $qb->orderBy('o.id', 'Desc');
        $paginator  = $this->get('knp_paginator');
        $paginator = $paginator->paginate(
            $qb->getQuery(),
            (int)$request->get('page', 1)/*page number*/,
            20/*limit per page*/
        );
        return $this->render('@DarkishWebsite/Offer/index.html.twig', array(
            'paginator' => $paginator,
            'upTrees' => $upTrees,
            'offerTree' => $offerTree
        ));
    }

}
