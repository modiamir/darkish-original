<?php

namespace Darkish\CategoryBundle\Controller;

use MyProject\Proxies\__CG__\OtherProject\Proxies\__CG__\stdClass;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Darkish\CategoryBundle\Entity\NewsTree;
use Darkish\CategoryBundle\Entity\News;
use Darkish\CategoryBundle\Form\NewsTreeType;
use Darkish\CategoryBundle\Form\NewsType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;


/**
 * NewsTree controller.
 *
 * @Route("/admin/newstree")
 */
class NewsTreeController extends Controller
{

    /**
     * Lists all NewsTree entities.
     *
     * @Route("/", name="admin_newstree", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DarkishCategoryBundle:NewsTree')->findAll();



        return array(
            'entities' => $entities,
            'tree' =>$this->getTree(),
        );
    }
    /**
     * Creates a new NewsTree entity.
     *
     * @Route("/", name="admin_newstree_create", options={"expose"=true})
     * @Method("POST")
     * @Template("DarkishCategoryBundle:NewsTree:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new NewsTree();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_newstree_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a NewsTree entity.
     *
     * @param NewsTree $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(NewsTree $entity)
    {
        $form = $this->createForm(new NewsTreeType(), $entity, array(
            'action' => $this->generateUrl('admin_newstree_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new NewsTree entity.
     *
     * @Route("/new", name="admin_newstree_new", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new NewsTree();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a NewsTree entity.
     *
     * @Route("/{id}", name="admin_newstree_show", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DarkishCategoryBundle:NewsTree')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsTree entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
            'tree' =>$this->getTree(),
        );
    }

    /**
     * Displays a form to edit an existing NewsTree entity.
     *
     * @Route("/{id}/edit", name="admin_newstree_edit", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DarkishCategoryBundle:NewsTree')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsTree entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'tree' =>$this->getTree(),
        );
    }

    /**
    * Creates a form to edit a NewsTree entity.
    *
    * @param NewsTree $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(NewsTree $entity)
    {
        $form = $this->createForm(new NewsTreeType(), $entity, array(
            'action' => $this->generateUrl('admin_newstree_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing NewsTree entity.
     *
     * @Route("/{id}", name="admin_newstree_update", options={"expose"=true})
     * @Method("PUT")
     * @Template("DarkishCategoryBundle:NewsTree:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DarkishCategoryBundle:NewsTree')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find NewsTree entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_newstree_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a NewsTree entity.
     *
     * @Route("/{id}", name="admin_newstree_delete", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DarkishCategoryBundle:NewsTree')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find NewsTree entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_newstree'));
    }

    /**
     * Creates a form to delete a NewsTree entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_newstree_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }



    /**
     * Displays a form to edit an existing NewsTree entity.
     *
     * @Route("/{id}/add", name="admin_newstree_addnews", options={"expose"=true})
     * @Template()
     */
    public function addNewsAction(Request $request, $id) {

        $news = new News();
        $em = $this->getDoctrine()->getManager();
        $newsTree = $em->getRepository('DarkishCategoryBundle:NewsTree')->find($id);
        /* @var $newsTree NewsTree */
        $news->setCategory($newsTree->getTreeIndex());
        $usr= $this->get('security.context')->getToken()->getUser();
        $news->setUserId($usr->getId());
        $form = $this->createForm(new NewsType(), $news);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $news->upload();

            $em->persist($news);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_newstree'));
        }




        return array(
            'form' => $form->createView(),
            'tree' =>$this->getTree(),
        );

    }


    private function getTree() {
        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:NewsTree');
        $products = $repository->findAll();
        $tree = array();
        foreach($products as $key => $product) {
            $node = array();
            /* @var $product NewsTree */
            $node['id'] = $product->getTreeIndex();
            $node['parent'] = $product->getUpTreeIndex();
            $node['text'] = $product->getTitle();
            $node['original_id'] = $product->getId();
            $tree[$key] = $node;

        }
        return $tree;
    }

    /**
     * @return mixed
     *
     *
     *
     *@Template("::base.html.twig")
     */
    public function getJsonTreeAction() {

        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new GetSetMethodNormalizer());

        $serializer = new Serializer($normalizers, $encoders);

        $repository = $this->getDoctrine()
            ->getRepository('DarkishCategoryBundle:NewsTree');
        $product = $repository->find(3);



        $jsonContent = $serializer->serialize($product, 'json');
        return array('content', $product);
        return new Response(
            $jsonContent,
            200
        );



    }
}
