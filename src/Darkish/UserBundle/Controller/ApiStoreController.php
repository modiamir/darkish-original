<?php

namespace Darkish\UserBundle\Controller;

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
     * @Get("/get_store_info/{record}", name="_api_store")
     * @Template()
     * @View(serializerGroups={"api.store", "file.details"})
     */
    public function getStoreInfoAction(Record $record)
    {

        return $record;
    }


    /**
     * @param Record $record
     * @return array|\Darkish\CategoryBundle\Entity\Product[]
     * @Get("/get_store_products/{record}", name="_api_store")
     * @View(serializerGroups={"api.list", "file.details", "api.store"})
     * @ApiDoc()
     */
    public function getStoreProductsAction(Record $record) {
        $products = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Product')
                         ->findBy(['record' => $record->getId()]);

        return $products;


    }

    /**
     * @param Record $record
     * @return array|\Darkish\CategoryBundle\Entity\Product[]
     * @Get("/get_store_products_per_group/{storeGroup}", name="_api_store")
     * @View(serializerGroups={"api.list", "file.details", "api.store"})
     * @ApiDoc()
     */
    public function getStoreProductsPerGroupAction(StoreGroup $storeGroup) {
        $products = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Product')
            ->findBy(['group' => $storeGroup->getId()]);

        return $products;
    }
}
