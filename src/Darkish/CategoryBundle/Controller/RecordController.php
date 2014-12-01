<?php

namespace Darkish\CategoryBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Darkish\CategoryBundle\Entity\Record;
use Darkish\CategoryBundle\Entity\MainTree;
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
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use JMS\Serializer\Serializer as JMSSerializer;
use JMS\Serializer\SerializationContext;

class RecordController extends Controller
{
    private $numPerPage = 10;

    /**
     * Lists all News entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DarkishCategoryBundle:Record')->findAll();




        return $this->render('DarkishCategoryBundle:Record:index.html.php', array(
            'entities' => $entities,

        ));
    }


    public function getTreeAction() {



        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:MainTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product NewsTree */
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
            ->getRepository('DarkishCategoryBundle:MainTree');
        $categories = $repository->findAll();
        $tree = array();
        foreach($categories as $key => $product) {
            $node = array();
            /* @var $product NewsTree */
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

    public function getJsonAction() {
        $Record = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:Record')
            ->find(1);

        $Tree = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:MainTree')
            ->find(1);

        /* @var $serializer JMSSerializer */
        $serializer = $this->get('jms_serializer');

        /* @var $Record Record */
        $Record->addTree($Tree);



        return new Response(
            $serializer->serialize($Tree, 'json', SerializationContext::create()->setGroups(array('list', 'Default')))
        );
    }

    public function getRecordForCategoryAction($cid, $page) {


        if($cid == -1) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
            //$newsList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('n.verify= :verify')
                ->setParameter('verify', false)
                ->setFirstResult(($page-1) * $this->numPerPage)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $newsList =  $query->getResult();


//            $encoders = array(new XmlEncoder(), new JsonEncoder());
//            $normalizers = array(new GetSetMethodNormalizer());
//
//            $serializer = new Serializer($normalizers, $encoders);
//
//            $serialized = $serializer->serialize($newsList, 'json');
            $serialized = $this->get('jms_serializer')->
                serialize($newsList, 'json', SerializationContext::create()->setGroups(array('list')));

            return new Response(
                $serialized
                , 200);
        }

        if($cid == -2) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News');
            //$newsList = $repository->findBy(array('category' => ""));

            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('n.category = :category')
                ->setParameter('category', "")
                ->setFirstResult(($page-1) * $this->numPerPage)
                ->setMaxResults($this->numPerPage)
            ;


            $query = $queryBuilder->getQuery();
            $newsList =  $query->getResult();

            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $serialized = $serializer->serialize($newsList, 'json');

            return new Response(
                $serialized
                , 200);
        }


        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:MainTree');

        $category =  $repository->find($cid);
        if(!$category) {
            return new Response("Cid input is invalid", 404);

        }
        else {
            /* @var $category NewsTree */
//            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:MainTree');
//            //$newsList = $repository->findBy(array('category' => $category->getTreeIndex()));
//
//            $queryBuilder = $repository->createQueryBuilder('n');
//            /* @var $queryBuilder QueryBuilder */
//            $queryBuilder->where('n.newstreeId = :ntid')
//                ->setParameter('ntid', $category->getId())
//                ->setFirstResult(($page-1) * $this->numPerPage)
//                ->setMaxResults($this->numPerPage)
//            ;
//
//
//            $query = $queryBuilder->getQuery();
//            $newsList =  $query->getResult();


            $serialized = $this->get('jms_serializer')->
                serialize($category->getRecords(), 'json', SerializationContext::create()->setGroups(array('record.list')));




//            $newsList = $category->getRecords();
//            $encoders = array(new XmlEncoder(), new JsonEncoder());
//            $normalizers = array(new GetSetMethodNormalizer());
//
//            $serializer = new Serializer($normalizers, $encoders);
//
//            $serialized = $serializer->serialize($newsList, 'json');

            return new Response(
                $serialized
                , 200);
        }

    }

    public function getRecordAction($id) {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
        $record = $repository->find($id);

        if(!$record) {
            return new Response("Record ID is invalid", 404);
        }

        return new Response($this->get('jms_serializer')->serialize($record, 'json', SerializationContext::create()->setGroups(array('record.details'))));
    }

    public function getCentersAction() {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Center');
        $centers = $repository->findAll();
        return new Response($this->get('jms_serializer')->serialize($centers, 'json', SerializationContext::create()->setGroups(array('center.list'))));
    }
}
