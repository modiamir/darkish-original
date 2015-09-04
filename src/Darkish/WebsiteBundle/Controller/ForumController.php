<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\CategoryBundle\Entity\ForumTree;
use FOS\RestBundle\Controller\Annotations\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ForumController extends Controller
{
    /**
     * @param $name
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/forum", name="website_forum")
     */
    public function indexAction()
    {
        $trees = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ForumTree')->findBy(['upTreeIndex'=>'00']);
        return $this->render('DarkishWebsiteBundle:Forum:index.html.twig', ['trees' => $trees ]);
    }

    /**
     * @param $forumtree
     * @Route("/forum/{tree_index}", name="website_forum_tree", options={"expose"=true})
     * @ParamConverter("forumtree", options={"mapping": {"tree_index": "treeIndex"}})
     */
    public function forumTreeAction(ForumTree $forumtree) {
        $trees = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ForumTree')->findBy(['upTreeIndex'=>'00']);
        return $this->render('DarkishWebsiteBundle:Forum:forumtree.html.twig', [
            'forumtree' => $forumtree,
            'trees' => $trees
        ]);
    }







}
