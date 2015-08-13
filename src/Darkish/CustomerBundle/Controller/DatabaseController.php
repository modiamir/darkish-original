<?php

namespace Darkish\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use JMS\Serializer\SerializationContext;
use Darkish\CustomerBundle\Form\CustomerEditProfileType;
use Darkish\CategoryBundle\Entity\ManagedFile;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use JMS\Serializer\Serializer as JMSSerializer;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Filters\Video\ResizeFilter;
use FFMpeg\Format\Video\X264;
use Alchemy\BinaryDriver\Listeners\DebugListener;
use \GetId3\GetId3Core as GetId3;
use FFMpeg\FFProbe;
use Darkish\CustomerBundle\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Darkish\CategoryBundle\Entity\DBase;
use Darkish\CategoryBundle\Entity\Estate;
use Darkish\CategoryBundle\Entity\Automobile;
use Doctrine\Common\Collections\ArrayCollection;


class DatabaseController extends Controller
{

    private $numOfItems = 3;

    /**
     * @Route("customer/ajax/get_database_data", defaults={"_format" = "json"})
     * @Method({"GET"})
     */
    public function getDatabaseData() {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        $storeData = array();
        $storeData['dbase_description'] = ($record->getDbaseDescription())?$record->getDbaseDescription():null;
        $storeData['dbase_banner'] = ($record->getDbaseBanner())?$record->getDbaseBanner():null;
        


        return new Response($this->get('jms_serializer')->serialize($storeData, 'json', SerializationContext::create()->setGroups(array('record.database', 'file.details'))));
    }
    

    /**
     * @Route("customer/ajax/estate", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function createEstateAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(6);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        if($record->getDbaseTypeIndex()->getId() == 1) {
            $entity = new \Darkish\CategoryBundle\Entity\Estate();
            $entity->setStatus(1);
            $entity->setCreated(new \DateTime());
            $entity->setRecord($record);
            $entity->setCustomer($user);

            $form = $this->createForm(new \Darkish\CategoryBundle\Form\EstateType(), $entity);
        } else {
            $entity = new \Darkish\CategoryBundle\Entity\Automobile();
            $entity->setStatus(1);
            $entity->setCreated(new \DateTime());
            $entity->setRecord($record);
            $entity->setCustomer($user);

            $form = $this->createForm(new \Darkish\CategoryBundle\Form\AutomobileType(), $entity);
        }

        

        
        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($entity);
        if (count($errors) > 0) {

            $errorsString = (string) $errors;

            return new JsonResponse(array('code'=>13, 'text' => $errorsString),500);
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            
            
            $em->persist($entity);

            $em->flush();


            
            return new Response($this->get('jms_serializer')->serialize($entity, 'json', SerializationContext::create()->setGroups(array('database.details', 'autobrand.list', 'autotype.list', 'autocolor.list', 'estatecontract.list', 'estatetype.list', 'file.details'))));

        }

        return new Response($form->getErrors()->__toString());

        
    }



    /**
     * @Route("customer/ajax/estate/{entity}", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function updateEstateAction(Request $request, DBase $entity) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(6);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        if($entity instanceof \Darkish\CategoryBundle\Entity\Estate) {
            $form = $this->createForm(new \Darkish\CategoryBundle\Form\EstateType(), $entity);
            $estateForm = $request->request->get('estate');
            $photos = (isset($estateForm['photos']))? $estateForm['photos'] : null;
            unset($estateForm['photos']);
            $request->request->set('estate', $estateForm);
        } elseif($entity instanceof \Darkish\CategoryBundle\Entity\Automobile) {
            $form = $this->createForm(new \Darkish\CategoryBundle\Form\AutomobileType(), $entity);
            $automobileForm = $request->request->get('automobile');
            $photos = (isset($automobileForm['photos']))? $automobileForm['photos'] : null;
            unset($automobileForm['photos']);
            $request->request->set('automobile', $automobileForm);
        }


        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($entity);
        if (count($errors) > 0) {

            $errorsString = (string) $errors;

            return new JsonResponse(array('code'=>13, 'text' => $errorsString),500);
        }

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            if($photos) {
                
                
                $currentImages = $entity->getPhotos();
                if($currentImages) {
                    $newImages = new ArrayCollection();
                    $eCollec = new ArrayCollection();
                    $neCollec = new ArrayCollection();
                    $rCollec = new ArrayCollection();
                    $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
                    foreach($photos as $image) {
                        $newImages->add($rep->find($image['id']));
                    }

                    $newImagesIterator = $newImages->getIterator();
                    while($newImagesIterator->valid()) {
                        if($currentImages->contains($newImagesIterator->current())) {
                            $eCollec->add($newImagesIterator->current());
                        } else {
                            $neCollec->add($newImagesIterator->current());
                        }
                        $newImagesIterator->next();
                    }

                    $currentImagesIterator = $currentImages->getIterator();
                    while($currentImagesIterator->valid()) {
                        if(!$eCollec->contains($currentImagesIterator->current()) && !$neCollec->contains($currentImagesIterator->current())) {
                            $currentImages->removeElement($currentImagesIterator->current());
                        }
                        $currentImagesIterator->next();
                    }

                    $neCollecIterator = $neCollec->getIterator();
                    while($neCollecIterator->valid()) {
                        $currentImages->add($neCollecIterator->current());
                        $neCollecIterator->next();
                    }
                }






                
            } else {
                $entity->getPhotos()->clear();
            }
            
            $em->persist($entity);

            $em->flush();



            return new Response($this->get('jms_serializer')->serialize($entity, 'json', SerializationContext::create()->setGroups(array('database.details', 'autobrand.list', 'autotype.list', 'autocolor.list', 'estatecontract.list', 'estatetype.list', 'file.details'))));

        }

        return new Response($form->getErrors()->__toString());

        
    }


    /**
     * @Route("customer/ajax/database/all", defaults={"_format"="json"})
     */
    public function getAllDatabaseAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(6);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }



        $record = $user->getRecord();

        $dbtype = ($record->getDbaseTypeIndex()->getId() == 1)? "Estate" : "Automobile";
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT d from \Darkish\CategoryBundle\Entity\DBase d where d.record = :rid and d instance of :dbtype");
        $query->setParameter('rid', $record->getId());
        $query->setParameter('dbtype', $dbtype);

        $estates = $query->getResult();

        return new Response($this->get('jms_serializer')->serialize($estates, 'json', SerializationContext::create()->setGroups(array('database.details', 'autobrand.list', 'autotype.list', 'autocolor.list', 'file.details'))));
    }


    /**
     * @Route("customer/ajax/database/search", defaults={"_format" = "json"})
     * @Method({"POST"})
     */
    public function searchDatabase(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(6);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }


        $record = $user->getRecord();

        $dbtype = ($record->getDbaseTypeIndex()->getId() == 1)? "Estate" : "Automobile";

        switch ($dbtype) {

            case 'Estate':
                $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Estate');
                break; 
            
            case 'Automobile':
                $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Automobile');
                break;
        }

        $qb = $repo->createQueryBuilder('db');
        $qb->where('db.customer = :cid')->setParameter('cid', $user->getId());
        $qb->andWhere('db.record = :rid')->setParameter('rid', $record->getId());
        
        if($request->request->has('automobile_brand')) {
            $qb->andWhere('db.automobileBrand = :bid')->setParameter('bid', $request->request->get('automobile_brand'));
        }

        if($request->request->has('automobile_type')) {
            $qb->andWhere('db.automobileType = :tid')->setParameter('tid', $request->request->get('automobile_type'));
        }

        if($request->request->has('automobile_created_year')) {
            $qb->andWhere('db.createdYear = :cdate')->setParameter('cdate', $request->request->get('automobile_created_year'));    
        }

        if($request->request->has('automobile_price')) {
            
            $price = $request->request->get('automobile_price');

            $bottomPrice = $price - $price/10;
            $topPrice = $price + $price/10;
            $qb->andWhere($qb->expr()->between('db.price', $bottomPrice, $topPrice));
            
        }

        if($request->request->has('estate_price')) {
            
            $price = $request->request->get('estate_price');

            $bottomPrice = $price - $price/10;
            $topPrice = $price + $price/10;
            $qb->andWhere($qb->expr()->between('db.price', $bottomPrice, $topPrice));
            
        }

        if($request->request->has('estate_contract_type')) {
            $qb->andWhere('db.contractType = :ctid')->setParameter('ctid', $request->request->get('estate_contract_type'));
        }

        if($request->request->has('estate_type')) {
            $qb->andWhere('db.estateType = :etid')->setParameter('etid', $request->request->get('estate_type'));
        }

        if($request->request->has('estate_dimension')) {
            
            $dimension = $request->request->get('estate_dimension');

            $bottomDimension = $dimension - $dimension/10;
            $topDimension = $dimension + $dimension/10;
            $qb->andWhere($qb->expr()->between('db.dimension', $bottomDimension, $topDimension));
        }

        if($request->request->has('lowest_id')) {
            $qb->andWhere('db.id < :lowesid')->setParameter('lowesid', $request->request->get('lowest_id'));
        }

        $qb->orderBy('db.id', 'DESC');
        $qb->setMaxResults($this->numOfItems);

        // return new Response($this->get('jms_serializer')->serialize($qb->getQuery()->getSQL(), 'json'));
        $dbs = $qb->getQuery()->getResult();

        
        return new Response($this->get('jms_serializer')->serialize(array($dbs), 'json', SerializationContext::create()->setGroups(array('database.details', 'autobrand.list', 'autotype.list', 'autocolor.list', 'estatecontract.list', 'estatetype.list', 'file.details'))));
    }

    /**
     * @Route("customer/ajax/get_estate_types", defaults={"_format" = "json"})
     */
    public function getEstateTypes() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT et from \Darkish\CategoryBundle\Entity\EstateType et order by et.sort asc");
        $estateTypes = $query->getResult();
        return new Response($this->get('jms_serializer')->serialize($estateTypes, 'json'));
    }

    /**
     * @Route("customer/ajax/get_contract_types", defaults={"_format" = "json"})
     */
    public function getContractTypes() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT et from \Darkish\CategoryBundle\Entity\ContractType et order by et.sort asc");
        $estateTypes = $query->getResult();
        return new Response($this->get('jms_serializer')->serialize($estateTypes, 'json'));
    }

    /**
     * @Route("customer/ajax/get_estate_features", defaults={"_format" = "json"})
     */
    public function getEstateFeatures() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT et from \Darkish\CategoryBundle\Entity\EstateFeatures et order by et.sort asc");
        $estateTypes = $query->getResult();
        return new Response($this->get('jms_serializer')->serialize($estateTypes, 'json'));
    }

    /**
     * @Route("customer/ajax/get_automobile_types", defaults={"_format" = "json"})
     */
    public function getAutomobileTypes() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT et from \Darkish\CategoryBundle\Entity\AutomobileType et order by et.sort asc");
        $estateTypes = $query->getResult();
        return new Response($this->get('jms_serializer')->serialize($estateTypes, 'json'));
    }

    /**
     * @Route("customer/ajax/get_automobile_brands", defaults={"_format" = "json"})
     */
    public function getAutomobileBrands() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT et from \Darkish\CategoryBundle\Entity\AutomobileBrand et order by et.sort asc");
        $estateTypes = $query->getResult();
        return new Response($this->get('jms_serializer')->serialize($estateTypes, 'json'));
    }

    /**
     * @Route("customer/ajax/get_automobile_colors", defaults={"_format" = "json"})
     */
    public function getAutomobileColor() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT et from \Darkish\CategoryBundle\Entity\AutomobileColor et order by et.sort asc");
        $estateTypes = $query->getResult();
        return new Response($this->get('jms_serializer')->serialize($estateTypes, 'json'));
    }

    /**
     * @Route("customer/ajax/get_automobile_features", defaults={"_format" = "json"})
     */
    public function getAutomobileFeatures() {
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery("SELECT et from \Darkish\CategoryBundle\Entity\AutomobileFeatures et order by et.sort asc");
        $estateTypes = $query->getResult();
        return new Response($this->get('jms_serializer')->serialize($estateTypes, 'json'));
    }


    /**
     * @Route("customer/ajax/database/get_item/{item}", defaults={"_format"="json"})
     */
    public function getDatabaseItem(DBase $item) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(6);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        return new Response($this->get('jms_serializer')->serialize($item, 'json', SerializationContext::create()->setGroups(array('database.details', 'autobrand.list', 'autotype.list', 'autocolor.list', 'estatecontract.list', 'estatetype.list', 'file.details'))));
    }


    /**
     * @Route("customer/ajax/database/save_details", defaults={"_format" = "json"})
     * @Method({"POST"})
     */
    public function saveDatabaseDetails(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(6);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }
        $em = $this->getDoctrine()->getManager();
        $record = $user->getRecord();

        if($request->get('description')) {
            $record->setDbaseDescription($request->get('description'));    
        }
        if($request->get('banner')) {
            $bannerReq = $request->get('banner');
            $banner = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile')->find($bannerReq['id']);
            if(!$banner) {
                throw new \Exception("Banner is not valid", 404);
            }
            $record->setDbaseBanner($banner);
        } else {
            $record->setDbaseBanner(null);
        }

        

        $em = $this->getDoctrine()->getManager();
        $em->persist($record);
        $em->flush();
        
        $storeData['dbase_description'] = $record->getDbaseDescription();
        $storeData['dbase_banner'] = $record->getDbaseBanner();

        return new Response($this->get('jms_serializer')->serialize($storeData, 'json', SerializationContext::create()->setGroups(array('record.store'))));

    }

    /**
     * @Route("customer/ajax/database/delete/{item}", defaults={"_format"="json"})
     * @Method({"DELETE"})
     */
    public function removeProduct(\Darkish\CategoryBundle\Entity\DBase $item) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();
        return new JsonResponse(['Delete done']);
    }
}
