<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\CategoryBundle\Entity\Record;
use Darkish\CommentBundle\Entity\AnonymousComment;
use Darkish\CommentBundle\Entity\Comment;
use Darkish\CommentBundle\Entity\RecordThread;
use Darkish\WebsiteBundle\Form\CommentType;
use FOS\RestBundle\Controller\Annotations\Route;
use Proxies\__CG__\Darkish\CommentBundle\Entity\NewsThread;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentController extends Controller
{
    public function indexAction($name)
    {
        $record= new Record();
        return $this->render('DarkishWebsiteBundle:Block:comment_list.html.twig', array('record' => $record));
    }

    /**
     * @param Request $request
     * @Route("/comment/post", name="website_comment_post")
     */
    public function postCommentAction(Request $request) {
        $comment = new AnonymousComment();
        $form = $this->createForm(new CommentType(), $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            switch($request->get('entity_type'))
            {
                case 'record':
                    $entity = $this->getDoctrine()
                        ->getRepository('DarkishCategoryBundle:Record')
                        ->find($request->get('entity_id'));
                    $thread = $this->getDoctrine()->getRepository('DarkishCommentBundle:RecordThread')
                        ->findOneBy(['target'=>$request->get('entity_id')]);
                    if(!$thread) {
                        $thread = new RecordThread();
                        $thread->setTarget($entity);
                        $thread->setLastCommentAt(new \DateTime());
                        $thread->setNumComments(1);
                    }
                    $url = $this->generateUrl('website_record_single', ['record' => $entity->getId()]);
                    break;
                case 'news':
                    $entity = $this->getDoctrine()
                        ->getRepository('DarkishCategoryBundle:News')
                        ->find($request->get('entity_id'));
                    $thread = $this->getDoctrine()->getRepository('DarkishCommentBundle:NewsThread')
                        ->findOneBy(['target'=>$request->get('entity_id')]);
                    if(!$thread) {
                        $thread = new NewsThread();
                        $thread->setTarget($entity);
                        $thread->setLastCommentAt(new \DateTime());
                        $thread->setNumComments(1);
                    }
                    $url = $this->generateUrl('website_news_single', ['news' => $entity->getId()]);
                    break;
            }
//            $comment->setCreatedAt(new \DateTime());
//            $comment->setReplyCount(0);
            $comment->setThread($thread);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->persist($thread);

            $em->flush();
            return $this->redirect($url);
        }
        die($form->getErrorsAsString());
    }

    /**
     * @param Comment $parent
     * @return \Symfony\Component\Form\FormView
     * @Route("comment/get_form/{entityType}/{entityId}/{parent}", name="website_get_comment_form", options={"expose"=true});
     * @Template("DarkishWebsiteBundle:Comment:create-form.html.twig")
     */
    public function createFormAction($entityType, $entityId, Comment $parent = null) {
        $comment = new AnonymousComment();

        if($parent) {
            $comment->setParent($parent);
        }

        $form = $this->createForm(new CommentType(), $comment,[
            'action' => $this->container->get('router')->generate('website_comment_post'),
            'method' => 'POST',
        ]);
        return [
            'comment_form' => $form->createView(),
            'entity_type' => $entityType,
            'entity_id' => $entityId
        ];
    }


}
