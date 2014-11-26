<?php

namespace Darkish\CategoryBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Darkish\CategoryBundle\Entity\Offer;
use Darkish\CategoryBundle\Entity\OfferTree;
use Darkish\CategoryBundle\Form\NewsType;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\Form;
use Symfony\Component\Validator\Constraints\DateTime;
use Doctrine\ORM\QueryBuilder;

/**
 * News controller.
 *
 */
class OfferController extends Controller
{

    private $numPerPage = 4;

    /**
     * Lists all News entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DarkishCategoryBundle:Offer')->findAll();




        return $this->render('DarkishCategoryBundle:Offer:index.html.php', array(
            'entities' => $entities,

        ));
    }
    /**
     * Creates a new Offer entity.
     *
     */
    public function createAction(Request $request)
    {
        /*$entity = new News();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('news_show', array('id' => $entity->getId())));
        }

        return $this->render('DarkishCategoryBundle:News:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));*/





        $offer = new Offer();
        $em = $this->getDoctrine()->getManager();




        if($request->get('title')) {
            $offer->setTitle($request->get('title'));
        }


        $offer->setCreatedDate(new \DateTime);

        if($request->get('publishDate')) {
            $offer->setPublishDate($request->get('publishDate'));
        }

        if($request->get('expireDate')) {
            $offer->setExpireDate($request->get('expireDate'));
        }

        if($request->get('body')) {
            $offer->setBody($request->get('body'));
        }

        if($request->get('firstPhone')) {
            $offer->setFirstPhone($request->get('firstPhone'));
        }

        if($request->get('secondPhone')) {
            $offer->setSecondPhone($request->get('secondPhone'));
        }

        if($request->get('email')) {
            $offer->setEmail($request->get('email'));
        }

        if($request->get('unitNumber')) {
            $offer->setUnitNumber($request->get('unitNumber'));
        }

        $offer->setUserId($this->getUser()->getId());

        $offer->setStatus(false);

        if($request->get('offertreeId')) {
            $offerTree = $em->getRepository('DarkishCategoryBundle:OfferTree')->find($request->get('offertreeId'));
            /* @var $newsTree NewsTree */
            if($offerTree) {
                $offer->setCategory($offerTree->getTreeIndex());
                $offer->setOffertreeId($request->get('offertreeId'));
            }

        }


        $validator = $this->get('validator');
        $errors = $validator->validate($offer);






        if (count($errors) == 0) {
            $em = $this->getDoctrine()->getManager();

            //$news->upload();

            $em->persist($offer);
            $em->flush();

            //return $this->redirect($this->generateUrl('admin_newstree'));
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $serialized = $serializer->serialize($offer, 'json');

            return new Response($serialized);
        } else {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }






    }



    /**
     * Displays a form to edit an existing News entity.
     *
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $offer = $em->getRepository('DarkishCategoryBundle:Offer')->find($id);

        if (!$offer) {
            return new Response("404 Not Found", 404);
        }






        if($request->get('title')) {
            $offer->setTitle($request->get('title'));
        }



        $offer->setCreatedDate(new \DateTime);

        if($request->get('publishDate')) {
            $offer->setPublishDate($request->get('publishDate'));
        }

        if($request->get('expireDate')) {
            $offer->setExpireDate($request->get('expireDate'));
        }

        if($request->get('body')) {
            $offer->setBody($request->get('body'));
        }

        $offer->setUserId($this->getUser()->getId());

        if($request->get('firstPhone')) {
            $offer->setFirstPhone($request->get('firstPhone'));
        }

        if($request->get('secondPhone')) {
            $offer->setSecondPhone($request->get('secondPhone'));
        }

        if($request->get('email')) {
            $offer->setEmail($request->get('email'));
        }

        if($request->get('unitNumber')) {
            $offer->setUnitNumber($request->get('unitNumber'));
        }

        $offer->setStatus(false);

        if($request->get('offertreeId')) {
            $offerTree = $em->getRepository('DarkishCategoryBundle:OfferTree')->find($request->get('offertreeId'));
            /* @var $newsTree NewsTree */
            if($offerTree) {
                $offer->setCategory($offerTree->getTreeIndex());
                $offer->setOffertreeId($request->get('offertreeId'));
            }

        }






        $validator = $this->get('validator');
        $errors = $validator->validate($offer);






        if (count($errors) == 0) {
            $em = $this->getDoctrine()->getManager();

            //$news->upload();

            $em->persist($offer);
            $em->flush();

            //return $this->redirect($this->generateUrl('admin_newstree'));
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $serialized = $serializer->serialize($offer, 'json');

            return new Response($serialized);
        } else {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

    }


    /**
     * Deletes a News entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {


        $em = $this->getDoctrine()->getManager();
        $offer = $em->getRepository('DarkishCategoryBundle:Offer')->find($id);

        if (!$offer) {
            return new Response("404 Not Found", 404);
        }

        $em->remove($offer);
        $em->flush();


        return new Response("Deleted", 200);
    }




    public function approveAction($id) {
        $em = $this->getDoctrine()->getManager();
        $offer = $em->getRepository('DarkishCategoryBundle:Offer')->find($id);

        if (!$offer) {
            return new Response("404 Not Found", 404);
        }

        $offer->setStatus(true);

        $em->persist($offer);
        $em->flush();

        //return $this->redirect($this->generateUrl('admin_newstree'));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $serialized = $serializer->serialize($offer, 'json');

        return new Response($serialized);

    }


    public function getOfferForCategoryAction($cid, $page) {


        if($cid == -1) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Offer');
            //$newsList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('o');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('o.status= :status')
                ->setParameter('status', false)
                ->setFirstResult(($page-1) * $this->numPerPage)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $offerList =  $query->getResult();


            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $serialized = $serializer->serialize($offerList, 'json');

            return new Response(
                $serialized
                , 200);
        }

        if($cid == -2) {
            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Offer');
            //$newsList = $repository->findBy(array('category' => ""));

            $queryBuilder = $repository->createQueryBuilder('o');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('o.category = :category')
                ->setParameter('category', "")
                ->setFirstResult(($page-1) * $this->numPerPage)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $offerList =  $query->getResult();

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $serialized = $serializer->serialize($offerList, 'json');

            return new Response(
                $serialized
                , 200);
        }


        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:OfferTree');

        $category =  $repository->find($cid);
        if(!$category) {
            return new Response("Cid input is invalid", 404);

        }
        else {
            /* @var $category NewsTree */
            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Offer');
            //$newsList = $repository->findBy(array('category' => $category->getTreeIndex()));

            $queryBuilder = $repository->createQueryBuilder('o');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('o.offertreeId = :otid')
                ->setParameter('otid', $category->getId())
                ->setFirstResult(($page-1) * $this->numPerPage)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $offerList =  $query->getResult();

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $serialized = $serializer->serialize($offerList, 'json');

            return new Response(
                $serialized
                , 200);
        }

    }

    public function getTotalPagesForCatAction($cid) {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Offer');
        /* @var $qb QueryBuilder */
        $qb = $repository->createQueryBuilder('o');
        $qb->select('COUNT(o)');
        if($cid == -1) {
            $qb->where('o.status= :status')
                ->setParameter('status', false);
        } elseif($cid == -2) {
            $qb->where('o.category = :category')
               ->setParameter('category', "");
        } else {
            $repository = $this->getDoctrine()
                ->getRepository('DarkishCategoryBundle:OfferTree');

            $category =  $repository->find($cid);
            if(!$category) {
                return new Response("Cid input is invalid", 404);

            }
            $qb->where('o.offertreeId = :otid')
                ->setParameter('otid', $category->getId());

        }
        $count = $qb->getQuery()->getSingleScalarResult();
        return new Response(ceil($count/$this->numPerPage));
    }

    public function getOfferAction($id) {
        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:Offer');
        if($offer = $repository->find($id)) {
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $serialized = $serializer->serialize($offer, 'json');
            return new Response($serialized);
        } else {
            return new Response("Id input is invalid", 404);
        }

    }



    public function getTreeAction() {



        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:OfferTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product OfferTree */
            $node['id'] = $product->getId();
            $node['treeIndex'] = $product->getTreeIndex();
            $node['upTreeIndex'] = $product->getUpTreeIndex();
            $node['title'] = $product->getTitle();
            $tree[$key] = $node;
        }
        $hierarchy = $this->buildTree($tree);
        return new Response(
            json_encode($hierarchy),
            200
        );
    }


    public function getTreeLinearAction() {
        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:OfferTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product OfferTree */
            $node['id'] = $product->getId();
            $node['treeIndex'] = $product->getTreeIndex();
            $node['upTreeIndex'] = $product->getUpTreeIndex();
            $node['title'] = $product->getTitle();
            $tree[$key] = $node;
        }

        return new Response(
            json_encode($tree),
            200
        );
    }

    private function buildTree(array $elements, $parentId = "#") {
        $branch = array();

        foreach ($elements as $element) {
            if ($element['upTreeIndex'] === $parentId) {
                $children = $this->buildTree($elements, $element['treeIndex']);
                if ($children) {
                    $element['children'] = $children;
                }
                $branch[] = $element;
            }
        }

        return $branch;
    }

    public function generateCsrfAction($intention) {

        $csrf = $this->get('form.csrf_provider'); //Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider by default
        $token = $csrf->generateCsrfToken($intention); //Intention should be empty string, if you did not define it in parameters

        return new JsonResponse($token);
    }


    public function isCsrfValidAction($token, $intention) {
        $csrf = $this->get('form.csrf_provider'); //Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider by default
        return new JsonResponse($csrf->isCsrfTokenValid($intention, $token));
    }

}
