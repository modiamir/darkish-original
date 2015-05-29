<?php

namespace Darkish\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	$name = 'amir';
        return $this->render('DarkishWebsiteBundle:Default:index.html.twig', array('name' => $name));
    }
}
