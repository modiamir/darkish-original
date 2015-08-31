<?php

namespace Darkish\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MusicController extends Controller
{

    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/play")
     */
    public function indexAction()
    {
        return $this->render('DarkishWebsiteBundle:Music:index.html.twig');
    }
}
