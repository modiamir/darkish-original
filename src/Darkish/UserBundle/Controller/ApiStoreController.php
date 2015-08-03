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
        $em = $this->getDoctrine()->getManager();
        $storeCache = $this->getDoctrine()
                      ->getRepository('DarkishCategoryBundle:Cache\StoreCache')
                      ->findOneBy(['recordId' => $record->getId()]);
        if(!$storeCache ) {
            $storeCache = new StoreCache();
            $storeCache->setJson($this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->generateStoreCache($record, $this->get('jms_serializer')));
            $storeCache->setRecordId($record);
            if($record->getMarketLastUpdate()) {
                $record->setMarketLastCacheCreate($record->getMarketLastUpdate());
            } else {
                $now = new \DateTime();
                $record->setMarketLastCacheCreate($now);
                $record->setMarketLastUpdate($now);

            }
            $em->persist($storeCache);
            $em->persist($record);
            $em->flush();

        } elseif($record->getMarketLastUpdate() > $record->getMarketLastCacheCreate()) {
            $storeCache->setJson($this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->generateStoreCache($record, $this->get('jms_serializer')));
            $record->setMarketLastCacheCreate($record->getMarketLastUpdate());
        }



        return $storeCache->getJson();

    }





}
