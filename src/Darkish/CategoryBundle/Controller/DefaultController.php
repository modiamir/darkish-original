<?php

namespace Darkish\CategoryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {

        return $this->render('DarkishCategoryBundle:Default:index.html.twig', array('name' => $name));
    }
    public function testAction() {
        return new Response("test");
    }
}
