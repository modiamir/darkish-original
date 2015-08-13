<?php

namespace Darkish\UserBundle\Controller;

use Darkish\CategoryBundle\Entity\Cache\StoreCache;
use Darkish\CategoryBundle\Entity\Record;
use Darkish\CategoryBundle\Entity\StoreGroup;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Route;
use FOS\RestBundle\Controller\Annotations\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;

class ApiStoreController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/get_store_info/{record}", name="_api_store")
     * @ApiDoc()
     * @View
     */
    public function getStoreInfoAction(Record $record)
    {
        $storeCache = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->getStoreInfo($record, $this->get('jms_serializer'));


        return $storeCache->getJson();

    }





}
