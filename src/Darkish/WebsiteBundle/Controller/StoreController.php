<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\CategoryBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/", host="%domain%")
 */
class StoreController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("record/store/{product}", name="website_store_product_modal")
     */
    public function indexAction(Product $product)
    {
        return new Response($product->getId().'-'.$product->getTitle());
    }
}
