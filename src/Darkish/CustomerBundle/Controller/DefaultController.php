<?php

namespace Darkish\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    
    /**
     * 
     * @Route("/customer")
     * @Template("DarkishCustomerBundle:Default:index.html.php")
     */
    public function indexAction() {
        
        return array();
    }
    
    /**
     * 
     * @Route("/test")
     * 
     */
    public function testAction() {
        $customer = $this->getDoctrine()->getRepository('DarkishCustomerBundle:Customer')->find(1);
        return new \Symfony\Component\HttpFoundation\Response($customer->getRoles()[0]->getName());
    }
}
