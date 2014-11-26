<?php

namespace Darkish\CategoryBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Darkish\CategoryBundle\Entity\News;
use Darkish\CategoryBundle\Entity\NewsTree;
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

/**
 * News controller.
 *
 */
class NewsController extends Controller
{

    private $numPerPage = 4;

    /**
     * Lists all News entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DarkishCategoryBundle:News')->findAll();




        return $this->render('DarkishCategoryBundle:News:index.html.php', array(
            'entities' => $entities,

        ));
    }
    /**
     * Creates a new News entity.
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





        $news = new News();
        $em = $this->getDoctrine()->getManager();




        if($request->get('title')) {
            $news->setTitle($request->get('title'));
        }

        if($request->get('subTitle')) {
            $news->setSubTitle($request->get('subTitle'));
        }

        $news->setCreatedDate(new \DateTime);

        if($request->get('publishDate')) {
            $news->setPublishDate($request->get('publishDate'));
        }

        if($request->get('expireDate')) {
            $news->setExpireDate($request->get('expireDate'));
        }

        if($request->get('body')) {
            $news->setBody($request->get('body'));
        }

        $news->setUserId($this->getUser()->getId());

        $news->setStatus(false);

        if($request->get('newstreeId')) {
            $newsTree = $em->getRepository('DarkishCategoryBundle:NewsTree')->find($request->get('newstreeId'));
            /* @var $newsTree NewsTree */
            if($newsTree) {
                $news->setCategory($newsTree->getTreeIndex());
                $news->setNewstreeId($request->get('newstreeId'));
            }

        }

        if($request->get('isCompetition') == 0 || $request->get('isCompetition') == 1 ) {
            $news->setIsCompetition($request->get('isCompetition'));
        }

        if($request->get('trueAnswer')) {
            $news->setTrueAnswer($request->get('trueAnswer'));
        }

        if($request->get('rate')) {
            $news->setRate($request->get('rate'));
        }




        $validator = $this->get('validator');
        $errors = $validator->validate($news);






        if (count($errors) == 0) {
            $em = $this->getDoctrine()->getManager();

            //$news->upload();

            $em->persist($news);
            $em->flush();

            //return $this->redirect($this->generateUrl('admin_newstree'));
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $serialized = $serializer->serialize($news, 'json');

            return new Response($serialized);
        } else {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }






    }

    /**
     * Creates a form to create a News entity.
     *
     * @param News $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(News $entity)
    {
        $form = $this->createForm(new NewsType(), $entity, array(
            'action' => $this->generateUrl('news_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new News entity.
     *
     */
    public function newAction()
    {
        $entity = new News();
        $form   = $this->createCreateForm($entity);

        return $this->render('DarkishCategoryBundle:News:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a News entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DarkishCategoryBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('DarkishCategoryBundle:News:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing News entity.
     *
     */
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository('DarkishCategoryBundle:News')->find($id);

        if (!$news) {
            return new Response("404 Not Found", 404);
        }






        if($request->get('title')) {
            $news->setTitle($request->get('title'));
        }

        if($request->get('subTitle')) {
            $news->setSubTitle($request->get('subTitle'));
        }

        $news->setCreatedDate(new \DateTime);

        if($request->get('publishDate')) {
            $news->setPublishDate($request->get('publishDate'));
        }

        if($request->get('expireDate')) {
            $news->setExpireDate($request->get('expireDate'));
        }

        if($request->get('body')) {
            $news->setBody($request->get('body'));
        }

        $news->setUserId($this->getUser()->getId());

        $news->setStatus(false);

        if($request->get('newstreeId')) {
            $newsTree = $em->getRepository('DarkishCategoryBundle:NewsTree')->find($request->get('newstreeId'));
            /* @var $newsTree NewsTree */
            if($newsTree) {
                $news->setCategory($newsTree->getTreeIndex());
                $news->setNewstreeId($request->get('newstreeId'));
            }

        }

        if($request->get('isCompetition') == 0 || $request->get('isCompetition') == 1 ) {
            $news->setIsCompetition($request->get('isCompetition'));
        }

        if($request->get('trueAnswer')) {
            $news->setTrueAnswer($request->get('trueAnswer'));
        }

        if($request->get('rate')) {
            $news->setRate($request->get('rate'));
        }




        $validator = $this->get('validator');
        $errors = $validator->validate($news);






        if (count($errors) == 0) {
            $em = $this->getDoctrine()->getManager();

            //$news->upload();

            $em->persist($news);
            $em->flush();

            //return $this->redirect($this->generateUrl('admin_newstree'));
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $serialized = $serializer->serialize($news, 'json');

            return new Response($serialized);
        } else {
            $errorsString = (string) $errors;

            return new Response($errorsString);
        }

    }

    /**
    * Creates a form to edit a News entity.
    *
    * @param News $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(News $entity)
    {
        $form = $this->createForm(new NewsType(), $entity, array(
            'action' => $this->generateUrl('news_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing News entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DarkishCategoryBundle:News')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find News entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('news_edit', array('id' => $id)));
        }

        return $this->render('DarkishCategoryBundle:News:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a News entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {


        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('DarkishCategoryBundle:News')->find($id);

        if (!$news) {
            return new Response("404 Not Found", 404);
        }

        $em->remove($news);
        $em->flush();


        return new Response("Deleted", 200);
    }

    /**
     * Creates a form to delete a News entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('news_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }


    public function approveAction($id) {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('DarkishCategoryBundle:News')->find($id);

        if (!$news) {
            return new Response("404 Not Found", 404);
        }

        $news->setStatus(true);
        //$news->upload();

        $em->persist($news);
        $em->flush();

        //return $this->redirect($this->generateUrl('admin_newstree'));
        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $serialized = $serializer->serialize($news, 'json');

        return new Response($serialized);

    }


    public function getNewsForCategoryAction($cid, $page) {


        if($cid == -1) {

            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News');
            //$newsList = $repository->findBy(array('status' => false));


            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('n.status= :status')
                ->setParameter('status', false)
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
            ->getRepository('DarkishCategoryBundle:NewsTree');

        $category =  $repository->find($cid);
        if(!$category) {
            return new Response("Cid input is invalid", 404);

        }
        else {
            /* @var $category NewsTree */
            $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News');
            //$newsList = $repository->findBy(array('category' => $category->getTreeIndex()));

            $queryBuilder = $repository->createQueryBuilder('n');
            /* @var $queryBuilder QueryBuilder */
            $queryBuilder->where('n.newstreeId = :ntid')
                ->setParameter('ntid', $category->getId())
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

    }

    public function getTotalPagesForCatAction($cid) {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News');
        /* @var $qb QueryBuilder */
        $qb = $repository->createQueryBuilder('n');
        $qb->select('COUNT(n)');
        if($cid == -1) {
            $qb->where('n.status= :status')
                ->setParameter('status', false);
        } elseif($cid == -2) {
            $qb->where('n.category = :category')
               ->setParameter('category', "");
        } else {
            $repository = $this->getDoctrine()
                ->getRepository('DarkishCategoryBundle:NewsTree');

            $category =  $repository->find($cid);
            if(!$category) {
                return new Response("Cid input is invalid", 404);

            }
            $qb->where('n.newstreeId = :ntid')
                ->setParameter('ntid', $category->getId());

        }
        $count = $qb->getQuery()->getSingleScalarResult();
        return new Response(ceil($count/$this->numPerPage));
    }

    public function getNewsAction($id) {
        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:News');
        if($news = $repository->find($id)) {
            $encoders = array(new XmlEncoder(), new JsonEncoder());
            $normalizers = array(new GetSetMethodNormalizer());

            $serializer = new Serializer($normalizers, $encoders);

            $serialized = $serializer->serialize($news, 'json');
            return new Response($serialized);
        } else {
            return new Response("Id input is invalid", 404);
        }

    }



    public function getTreeAction() {



        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:NewsTree');
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
            ->getRepository('DarkishCategoryBundle:NewsTree');
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

    public function generateCsrfAction($intention) {

        $csrf = $this->get('form.csrf_provider'); //Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider by default
        $token = $csrf->generateCsrfToken($intention); //Intention should be empty string, if you did not define it in parameters

        return new JsonResponse($token);
    }


    public function isCsrfValidAction($token, $intention) {
        $csrf = $this->get('form.csrf_provider'); //Symfony\Component\Form\Extension\Csrf\CsrfProvider\SessionCsrfProvider by default
        return new JsonResponse($csrf->isCsrfTokenValid($intention, $token));
    }


    public function uploadImageAction($iid, $action, Request $request ) {
        if($request->files->has('upload')) {
            $upload = $request->files->get('upload');
        } else {
            return new Response('File doesn\'t exist', 401);
        }




        $fs = new Filesystem();
        $dir = 'uploads/temporary/news/'.$this->getUser()->getId().'_'.$iid;
        try {
            if(!$fs->exists($dir)) {
                $fs->mkdir($dir);
            }

        } catch (IOExceptionInterface $e) {
            return new Response('error', 401);
        }

        /* @var $upload UploadedFile */
        $upload->move($dir,$upload->getClientOriginalName());







        $url = "http://localhost/darkish/web/uploads/documents/1.jpg";





        return new Response("

         <script>window.parent.CKEDITOR.tools.callFunction(
         ".                                      $request->query->get('CKEditorFuncNum')        .
            ", '" . $url . "');</script>


        ");
    }

    public function generateRandomUploadKeyAction() {
        return new Response($this->getUser()->getId().time().rand(1000,9999));

    }

    public function getNewIdAction() {
        $repository = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News');
        //$newsList = $repository->findBy(array('status' => false));


        $queryBuilder = $repository->createQueryBuilder('n');
        /* @var $queryBuilder QueryBuilder */
        $queryBuilder->select('n.id')->orderBy('n.id','DESC')->setFirstResult(0)->setMaxResults(1);
        $query = $queryBuilder->getQuery();
        $newsList =  $query->getResult();

        if(count($newsList)) {
            return new Response($newsList[0]['id']+1);
        } else {
            return 1;
        }


    }

    public function getFilesImagesAction($entityId) {
        $images = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News')->getImagesFiles($entityId);

        return new Response($images);
    }
}
