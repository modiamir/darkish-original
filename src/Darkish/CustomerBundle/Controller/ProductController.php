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
use Darkish\CategoryBundle\Entity\Message;
use Darkish\CategoryBundle\Entity\MessageThread;
use Doctrine\Common\Collections\ArrayCollection;


class ProductController extends Controller
{

    /**
     * @Route("customer/ajax/product", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function createProductAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        $entity = new \Darkish\CategoryBundle\Entity\Product();
        $entity->setSort(1);
        $entity->setStatus(1);
        $entity->setCreated(new \DateTime());
        $entity->setRecord($record);
        $entity->setCustomer($user);

        $form = $this->createForm(new \Darkish\CategoryBundle\Form\ProductType(), $entity);

        $photoId = $request->request->get('product[photos]', null, true);
        $productForm = $request->request->get('product');
        $producPhotos = (isset($productForm['photos']))? $productForm['photos'] : null;
        unset($productForm['photos']);
        $request->request->set('product', $productForm);

        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($entity);
        if (count($errors) > 0) {

            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

//            return new JsonResponse([$errorsString],500);
        }


        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            if($producPhotos) {
                
                
                $currentImages = $entity->getPhotos();
                if($currentImages) {
                    $newImages = new ArrayCollection();
                    $eCollec = new ArrayCollection();
                    $neCollec = new ArrayCollection();
                    $rCollec = new ArrayCollection();
                    $rep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');
                    foreach($producPhotos as $image) {
                        $newImages->add($rep->find($image));
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






                
            }

            $em->persist($entity);

            $em->flush();


            

            return new Response($this->get('jms_serializer')->serialize($entity, 'json', SerializationContext::create()->setGroups(array('product.details', 'file.details'))));
        }

        return new JsonResponse([$this->get('darkish.form_errors')->getFormErrors($form, true)], 500);

        
    }


    /**
     * @Route("customer/ajax/product/{product}", defaults={"_format"="json"},
     *     requirements={"product" = "\d+"}
     * )
     * @Method({"POST"})
     */
    public function updateProductAction(Request $request, \Darkish\CategoryBundle\Entity\Product $product) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        $entity = $product;
        
        $form = $this->createForm(new \Darkish\CategoryBundle\Form\ProductType(), $entity);

        $photoId = $request->request->get('product[photos]', null, true);
        $productForm = $request->request->get('product');
        $producPhotos = (isset($productForm['photos']))? $productForm['photos'] : null;
        unset($productForm['photos']);
        $request->request->set('product', $productForm);

        $form->handleRequest($request);

        $validator = $this->get('validator');
        $errors = $validator->validate($entity);
        if (count($errors) > 0) {

            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

            return new JsonResponse([$errorsString],500);
        }

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            if($producPhotos) {


                $currentImages = $entity->getPhotos();
                $currentImages->clear();

                $em->persist($product);
                $em->flush();

                $filerep = $this->getDoctrine()->getRepository('DarkishCategoryBundle:ManagedFile');

                foreach($producPhotos as $productId) {
                    $file = $filerep->find($productId);
                    $product->addPhoto($file);
                    $em->persist($file);
                }

            }

            

            $em->persist($product);
            $em->flush();
            // return new Response($this->get('jms_serializer')->serialize($err, 'json'));
            return new Response($this->get('jms_serializer')->serialize($entity, 'json', SerializationContext::create()->setGroups(array('product.details', 'file.details'))));
        }
        /* @var $formerror \Symfony\Component\Form\FormErrorIterator */
        $formerror =$form->getErrors();
        return new Response($form->getErrors()->__toString());

        
    }


    /**
     * @Route("customer/ajax/product/all", defaults={"_format"="json"})
     */
    public function getAllProductsAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT p from \Darkish\CategoryBundle\Entity\Product p where p.record = :rid");
        $query->setParameter('rid', $record->getId());

        $products = $query->getResult();

        return new Response($this->get('jms_serializer')->serialize($products, 'json', SerializationContext::create()->setGroups(array('product.details', 'file.details'))));
    }


    /**
     * @Route("customer/ajax/product/all/{group}", defaults={"_format"="json"})
     */
    public function getGroupProductsAction(\Darkish\CategoryBundle\Entity\StoreGroup $group) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery("SELECT p from \Darkish\CategoryBundle\Entity\Product p where p.record = :rid and p.group = :gid order by p.sort ASC");
        $query->setParameter('rid', $record->getId());
        $query->setParameter('gid', $group->getId());

        $products = $query->getResult();

        return new Response($this->get('jms_serializer')->serialize($products, 'json', SerializationContext::create()->setGroups(array('product.details', 'file.details'))));
    }

    /**
     * @Route("customer/ajax/product/sort_groups", defaults={"_format" = "json"})
     * @Method({"POST"})
     */
    public function sortGroupsAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        $groups = $request->get('groups');
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:StoreGroup');
        $em = $this->getDoctrine()->getManager();
        foreach ($groups as $key => $group) {
            $groupEntity = $repo->find($group['id']);
            $groupEntity->setSort($group['sort']);
            $em->persist($groupEntity);
        }
        $em->flush();
        return new JsonResponse(['Sort Done']);

    }

    /**
     * @Route("customer/ajax/product/add_group", defaults={"_format" = "json"})
     * @Method({"POST"})
     */
    public function addGroupsAction(Request $request) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $record = $user->getRecord();

        $group = $request->get('group');

        $allgroups = $this->getDoctrine()->getRepository('DarkishCategoryBundle:StoreGroup')
            ->findBy(['record' => $record->getId()]);

        if(count($allgroups)  >= 100) {
            return new JsonResponse(['حداکثر تعداد گروه در این فروشگاه استفاده شده است. امکان درج گروه جدید وجود ندارد.'], 403);
        }


        $groups = $this->getDoctrine()->getRepository('DarkishCategoryBundle:StoreGroup')
                ->findBy(['name' => $group['name'], 'record' => $record->getId()]);

        if(count($groups)) {
            return new JsonResponse(['
            گروه دیگری با همین نام در این فروشگاه به ثبت رسیده است.
            '], 403);
        }

        
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:StoreGroup');
        $groupEntity = new \Darkish\CategoryBundle\Entity\StoreGroup();
        $groupEntity->setSort($group['sort']);
        $groupEntity->setName($group['name']);
        $groupEntity->setRecord($record);

        $em = $this->getDoctrine()->getManager();
        $em->persist($groupEntity);
        $em->flush();
        return new Response($this->get('jms_serializer')->serialize($groupEntity, 'json', SerializationContext::create()->setGroups(['storegroup.details'])));

    }

    /**
     * @Route("customer/ajax/product/delete_group/{group}", defaults={"_format"="json"})
     * @Method({"DELETE"})
     */
    public function deleteGroupAction(\Darkish\CategoryBundle\Entity\StoreGroup $group) {
        $user = $this->get('security.context')->getToken()->getUser();
        /* @var $assistantAccess \Doctrine\Common\Collections\ArrayCollection */
        $assistantAccess = $user->getAssistantAccess();
        $role = $this->getDoctrine()->getRepository('DarkishCustomerBundle:CustomerRole')->find(7);
        if(!$assistantAccess->contains($role)) {
            throw new AccessDeniedException();
        }

        $products = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Product')
                ->findBy(['group' => $group->getId()]);
        if(count($products)) {
            return new JsonResponse(['Cant delete group. This group has products!'], 403);
        }

        $record = $user->getRecord();

        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();

        return new JsonResponse(['Delete done']);

    }

    /**
     * @Route("customer/ajax/product/sort", defaults={"_format"="json"})
     * @Method({"POST"})
     */
    public function sortProductsAction(Request $request) {
        $products = $request->get('products');
        if(!count($products)) {
            return new JsonResponse(['Sort Done']);    
        }
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Product');
        $em = $this->getDoctrine()->getManager();
        foreach ($products as $key => $product) {
            $prodEntity = $repo->find($product['id']);
            $prodEntity->setSort($product['sort']);
            $em->persist($prodEntity);
        }
        $em->flush();
        return new JsonResponse(['Sort Done']);
    }

    /**
     * @Route("customer/ajax/product/get/{product}", defaults={"_format"="json"})
     * @Method({"GET"})
     * 
     */
    public function getProductDetails(\Darkish\CategoryBundle\Entity\Product $product)  {
        return new Response($this->get('jms_serializer')->serialize($product, 'json', SerializationContext::create()->setGroups(['product.details', 'file.details'])));
    }


    /**
     * @Route("customer/ajax/product/delete/{product}", defaults={"_format"="json"})
     * @Method({"DELETE"})
     */
    public function removeProduct(\Darkish\CategoryBundle\Entity\Product $product) {
        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();
        return new JsonResponse(['Delete done']);
    }

    
}
