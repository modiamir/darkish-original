<?php

namespace Darkish\WebsiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Darkish\CategoryBundle\Entity\RecordRequest;
use Darkish\WebsiteBundle\Form\RecordRequestType;

/**
 * RecordRequest controller.
 *
 * @Route("/request/record", host="%domain%")
 */
class RecordRequestController extends Controller
{

    
    /**
     * Creates a new RecordRequest entity.
     *
     * @Route("/", name="request_record_create")
     * @Method("POST")
     * @Template("DarkishWebsiteBundle:RecordRequest:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new RecordRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'درخواست شما ثبت گردید. بعد از بررسی با شما تماس گرفته خواهد شد.'
            );
            return $this->redirect($this->generateUrl('request_record_new'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a RecordRequest entity.
     *
     * @param RecordRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(RecordRequest $entity)
    {
        $form = $this->createForm(new RecordRequestType(), $entity, array(
            'action' => $this->generateUrl('request_record_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new RecordRequest entity.
     *
     * @Route("/new", name="request_record_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new RecordRequest();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }
}
