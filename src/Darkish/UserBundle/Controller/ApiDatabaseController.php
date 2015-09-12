<?php

namespace Darkish\UserBundle\Controller;

use Darkish\CategoryBundle\Entity\Automobile;
use Darkish\CategoryBundle\Entity\Estate;
use Darkish\CategoryBundle\Entity\Record;
use Darkish\WebsiteBundle\Form\AutomobileSearchType;
use Darkish\WebsiteBundle\Form\EstateSearchType;
use Doctrine\ORM\EntityNotFoundException;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\View;
use JMS\Serializer\SerializationContext;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;


class ApiDatabaseController extends Controller
{


    /**
     * @Post("/search_database/{mode}/{modevalue}", name="_api_database", defaults={"_format"= "json"},
     * requirements={"mode": "global|record"})
     * @ApiDoc(
     * resource=true,
     *  section="Database API"
     * )
     * @View(serializerGroups={"api.list"})
     */
    public function searchDatabaseAction($mode, $modevalue= null, Request $request = null)
    {
        if($mode == 'record' )
        {
            if($modevalue)
            {
                $record = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->find($modevalue);

                if($record instanceof Record){
                    $dbType = $record->getDbaseTypeIndex();
                }else
                {
                    throw new EntityNotFoundException();
                }
            } else {
                throw new \Exception("You should specify a valid recordid for modevalue parameter in record mode");
            }

        } elseif($mode == 'global') {
            if(!in_array($modevalue, ['automobile', 'estate']))
            {
                throw new \Exception("You should specify a valid dbase type for modevalue parameter in global mode");
            }
        }





        if( ($mode == 'global' && $modevalue == 'estate' ) ||
            ($mode == 'record' && $dbType->getId() == 1) ) {
            $database = new Estate();
            $form = $this->container->get('form.factory')->create(new EstateSearchType(), $database, [
                'method' => 'POST'
            ]);
            $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Estate');
        } else
        {
            $database = new Automobile();
            $form = $this->container->get('form.factory')->create(new AutomobileSearchType(), $database, [
                'method' => 'POST'
            ]);
            $repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Automobile');
        }

        $form->handleRequest($this->container->get('request'));

        $prices = [];
        if($request->request->has('priceFrom'))
        {
            $prices['from'] = $request->get('priceFrom');
        }

        if($request->request->has('priceTo'))
        {
            $prices['to'] = $request->get('priceTo');
        }



        if($mode== 'global')
        {
            $query = $repo->search($database, $prices);
        } elseif($mode== 'record')
        {
            $query = $repo->search($database, $prices, $record);
        }



        return new Response($this->get('jms_serializer')->serialize($query->getResult(), 'json', SerializationContext::create()->setGroups(['api.details', 'api.list', 'file.details'])));
    }

    /**
     * @Post("/get_estate_types", name="_api_database_get_estate_types", defaults={"_format"= "json"},
     * requirements={"mode": "global|record"})
     * @ApiDoc(
     * resource=true,
     *  section="Database API"
     * )
     * @View()
     */
    public function getEstateTypesAction()
    {
        $estateTypes = $this->getDoctrine()->getRepository('DarkishCategoryBundle:EstateType')->findAll();

        return new Response($this->get('jms_serializer')->serialize($estateTypes, 'json'));
    }

    /**
     * @Post("/get_contract_types", name="_api_database_get_contract_types", defaults={"_format"= "json"},
     * requirements={"mode": "global|record"})
     * @ApiDoc(
     * resource=true,
     *  section="Database API"
     * )
     * @View()
     */
    public function getContractTypesAction()
    {
        $contractTypes = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ContractType')->findAll();

        return new Response($this->get('jms_serializer')->serialize($contractTypes, 'json'));
    }

    /**
     * @Post("/get_automobile_types", name="_api_database_get_automobile_types", defaults={"_format"= "json"},
     * requirements={"mode": "global|record"})
     * @ApiDoc(
     * resource=true,
     *  section="Database API"
     * )
     * @View()
     */
    public function getAutomobileTypesAction()
    {
        $automobileTypes = $this->getDoctrine()->getRepository('DarkishCategoryBundle:AutomobileType')->findAll();

        return new Response($this->get('jms_serializer')->serialize($automobileTypes, 'json'));
    }


    /**
     * @Post("/get_automobile_brands", name="_api_database_get_automobile_brands", defaults={"_format"= "json"},
     * requirements={"mode": "global|record"})
     * @ApiDoc(
     * resource=true,
     *  section="Database API"
     * )
     * @View()
     */
    public function getAutomobileBrandsAction()
    {
        $automobileBrands = $this->getDoctrine()->getRepository('DarkishCategoryBundle:AutomobileBrand')->findAll();

        return new Response($this->get('jms_serializer')->serialize($automobileBrands, 'json'));
    }
}
