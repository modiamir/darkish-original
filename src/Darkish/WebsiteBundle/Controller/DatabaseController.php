<?php

namespace Darkish\WebsiteBundle\Controller;

use Darkish\CategoryBundle\Entity\Estate;
use Darkish\CategoryBundle\Entity\Automobile;
use Darkish\WebsiteBundle\Form\AutomobileSearchType;
use Darkish\WebsiteBundle\Form\EstateSearchType;
use Ivory\GoogleMap\Overlays\Marker;
use Ivory\GoogleMap\Overlays\Animation;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Length;
use Darkish\CustomerBundle\Entity\Customer;
use Darkish\CategoryBundle\Entity\Record;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Zend\I18n\Validator\DateTime;

class DatabaseController extends Controller
{
    /**
     * @Route("/record/database/{type}/{record}", name="website_record_database", requirements={
     *      "type": "estate|automobile"
     * }, defaults={"record": null})
     */
    public function databaseAction($type, Record $record = null, Request $request) {

        if( $record &&
            (!$record->getDbaseEnable() || !$record->getDbaseEnableCustomer() || ($record->getExpireDate() < new \DateTime()) )
        ) {
            throw new NotFoundHttpException();
        }



        if($type == 'estate')
        {
            if($record && $record->getDbaseTypeIndex()->getId() != 1)
            {
                throw new NotFoundHttpException();
            }
            $database = new Estate();
            $form = $this->createForm(new EstateSearchType(), $database, [
                'method' => 'GET'
            ]);
            $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Estate');
            $formTemplate = 'DarkishWebsiteBundle:Database:estate-form.html.twig';
        }
        else
        {
            if($record && $record->getDbaseTypeIndex()->getId() != 2)
            {
                throw new NotFoundHttpException();
            }
            $database = new Automobile();
            $form = $this->createForm(new AutomobileSearchType(), $database, [
                'method' => 'GET'
            ]);
            $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Automobile');
            $formTemplate = 'DarkishWebsiteBundle:Database:automobile-form.html.twig';
        }

        if($record) {
            $form->remove('record');
        }

        $form->handleRequest($request);

        $prices = [];
        if($request->request->has('priceFrom'))
        {
            $prices['from'] = $request->get('priceFrom');
        }

        if($request->request->has('priceTo'))
        {
            $prices['to'] = $request->get('priceTo');
        }

        $pagination = $this->get('knp_paginator')->paginate(
            $repo->search($database, $prices, $record),
            $this->container->get('request')->query->getInt('page', 1),
            5
        );

//        $records = $this->getDoctrine()->getRepository();





        return $this->render('DarkishWebsiteBundle:Database:index.html.twig',[
            'record' => $record,
            'pagination' => $pagination,
            'form'=> $form->createView(),
            'form_template' => $formTemplate,
            'type' => $type
        ]);

    }

    /**
     * @Route("/record/database/get_boundries", name="website_record_database_boundries", options={"expose"=true}, defaults={"_format": "json"})
     */
    public function getDBaseSearchBoundries() {

        $filename = '/home/shahed/www/web/dbase_range_slider_boundries.json';

        return new Response(file_get_contents($filename));
    }


    /**
     * @Route("/record/database/get_automobile_data", name="website_record_database_automobile_data", options={"expose"=true}, defaults={"_format": "json"})
     */
    public function getAutomobileData() {
        return new Response($this->get('jms_serializer')
            ->serialize($this->getDoctrine()->getRepository('DarkishCategoryBundle:AutomobileType')->findAll(), 'json')
        );
    }
}
