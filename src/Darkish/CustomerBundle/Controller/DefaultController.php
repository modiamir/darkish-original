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
        return array('name' => 'test');
    }
}
