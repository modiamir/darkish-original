<?php

namespace Darkish\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Darkish\UserBundle\Entity\Operator;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Darkish\UserBundle\Form\OperatorType;


class OperatorController extends Controller
{
    
    /**
     * @Route("/admin/operator/manage")
     */
    public function manageAction() 
    {
        return $this->render('DarkishUserBundle:Operator:index.html.php');
    }
    
    /**
     * @Route(
     *      "/admin/operator/ajax/get_operators", 
     *      defaults={"_format": "json"}
     * )
     */
    public function getOperatorsAction() {
        $repo = $this->getDoctrine()->getRepository('DarkishUserBundle:Operator');
        $operators = $repo->findAll();
        return new Response($this->get('jms_serializer')->serialize($operators, 'json', SerializationContext::create()->setGroups(array('operator.list'))));
    }
    
    /**
     * @Route("admin/operator/ajax/search",defaults={"_format": "json"} )
     * @Method({"POST"})
     */
    public function searchOperatorAction(Request $request) {
        $data = $request->request->get('data');
        $repo = $this->getDoctrine()->getRepository('DarkishUserBundle:Operator');
        $qb = $repo->createQueryBuilder('o');
        /* @var $qb QueryBuilder */
        if(isset($data['search'])) {
            $keyword = $data['search']['predicateObject']['$'];
            $qb->orWhere($qb->expr()->like('o.email', $qb->expr()->literal('%' . $keyword . '%')));
            $qb->orWhere($qb->expr()->like('o.username', $qb->expr()->literal('%' . $keyword . '%')));                        
        }

        if(isset($data['sort'])) {
            $order = 'Asc';
            if($data['sort']['reverse'] == 'true') {
                $order = 'Desc';
            }
            $qb->orderBy('o.'.$data['sort']['predicate'], $order );
        }

        $qb->setFirstResult($data['pagination']['start']);
        $qb->setMaxResults($data['pagination']['number']);
        
        $res = $qb->getQuery()->getResult();
        $count = count($this->getDoctrine()->getRepository('DarkishUserBundle:Operator')->findAll());
        $numOfPages = ceil($count/$data['pagination']['number']);
        $searchRes = array('result' => $res, 'numOfPages' => $numOfPages);
        return new Response($this->get('jms_serializer')->serialize($searchRes, 'json', SerializationContext::create()->setGroups(array('operator.list'))));
    }
    
    /**
     * @Route(
     *      "/admin/operator/template/{name}"
     * )
     */
    public function getTemplateAction($name) {
        return $this->render('DarkishUserBundle:Operator:Templates/'.$name.'.php');
    }
    
    /**
     * @Route("/admin/operator/ajax/get_operator/{id}", defaults={"_format": "json"} )
     */
    public function getOperator($id) {
        try {
            $repo = $this->getDoctrine()->getRepository('DarkishUserBundle:Operator');
            $operator = $repo->find($id);
            return new Response($this->get('jms_serializer')->serialize($operator, 'json', SerializationContext::create()->setGroups(array('operator.details')) ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        
        
    }


    /**
     * @Route("/admin/operator/login", name="login_route")
     */
    public function loginAction(Request $request)
    {
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                    SecurityContextInterface::AUTHENTICATION_ERROR
            );
        } elseif (null !== $session && $session->has(SecurityContextInterface::AUTHENTICATION_ERROR)) {
            $error = $session->get(SecurityContextInterface::AUTHENTICATION_ERROR);
            $session->remove(SecurityContextInterface::AUTHENTICATION_ERROR);
        } else {
            $error = '';
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get(SecurityContextInterface::LAST_USERNAME);

        return $this->render(
                    ':security:login.html.php', array(
                    // last username entered by the user
                    'last_username' => $lastUsername,
                    'error' => $error,
                        )
        );
    }

    /**
     * @Route("/admin/is_remembered", name="security_remembered")
     */
    public function isRememberedAction() {
        /* @var $sc \Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken */
        $sc = $this->get('security.context')->getToken();
        
        
        return new JsonResponse($this->get('security.context')->isGranted(
        'IS_AUTHENTICATED_REMEMBERED'
       ));
    }
    
    /**
     * @Route("/admin/operator/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }
    
    /**
     * @Route("/admin/operator/logout", name="logout")
     */
    public function logoutAction()
    {
    }
    
    /**
     * @Route("/admin/operator/check_permission", name="check_permission")
     */
    public function checkPermissionAction() {
        $record = new \Darkish\CategoryBundle\Entity\Record();
        return new JsonResponse($this->get('security.context')->isGranted('edit', $record));
        
        
    }
    
    /**
     * 
     * @Route("admin/operator/ajax/create",defaults={"_format": "json"} )
     * @Method({"POST"})
     */
    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $operator = new Operator();
//        return new Response($this->get('jms_serializer')->serialize($request->request, 'json'));
        $form = $this->createForm(new OperatorType, $operator);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $em->persist($operator);
            $em->flush();
            return new Response($this->get('jms_serializer')->serialize($operator, 'json', SerializationContext::create()->setGroups(array('operator.details'))));
        }
        return new Response($form->getErrorsAsString());
    }
    
    
    /**
     * 
     * @Route("admin/operator/ajax/update/{id}",defaults={"_format": "json"} )
     * @Method({"POST"})
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $operator = $em->getRepository('DarkishUserBundle:Operator')->find($id);
//        return new Response($this->get('jms_serializer')->serialize($request->request, 'json'));
        $form = $this->createForm(new OperatorType, $operator);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $em->flush();
            return new Response($this->get('jms_serializer')->serialize($operator, 'json', SerializationContext::create()->setGroups(array('operator.details'))));
        }
        return new Response($form->getErrorsAsString());
    }
    
    /**
     * 
     * @Route("admin/operator/ajax/delete_operator", defaults={"_format": "json"})
     * @Method({"POST"})
     */
    public function deleteAction(Request $request) {
        try {
            
            if (!$request->request->has('id')) {
                throw new Exception('You should send an id to delete', 404);
            }
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $operator = $em->getRepository('DarkishUserBundle:Operator')->find($id);
            if(!$operator) {
                throw new Exception('Invalid operator id', '404');
            }
            $em->remove($operator);
            $em->flush();
            return new Response('removed');
            
        } catch (Exception $exc) {
            return new Response($exc->getTraceAsString());
        }

    }
    
    
    /**
     * @Route("admin/operator/ajax/toggle_is_active", defaults={"_format":"json"})
     * @Method({"POST"})
     */
    public function toggleIsActiveAction(Request $request) {
        try {
            
            if (!$request->request->has('id')) {
                throw new Exception('You should send an id to toggle active state', 404);
            }
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $operator = $em->getRepository('DarkishUserBundle:Operator')->find($id);
            if(!$operator) {
                throw new Exception('Invalid operator id', '404');
            }
            /* @var $operator Operator */
            $operator->setIsActive(($operator->getIsActive())? false : true);
            $em->persist($operator);
            $em->flush();
            return new Response('toggled');
            
        } catch (Exception $exc) {
            return new Response($exc->getTraceAsString());
        }
    }
    
    /**
     * @Route("admin/operator/ajax/get_roles", defaults={"_format": "json"})
     * @Method({"GEt"})
     */
    public function getRolesAction() {
        $em = $this->getDoctrine()->getManager();
        $roles = $em->getRepository('DarkishUserBundle:Role')->findAll();
        return new Response($this->get('jms_serializer')->serialize($roles, 'json',SerializationContext::create()->setGroups(array('role.list'))));
    }
    
    /**
     * 
     * @Route("admin/operator/ajax/get_username", defaults={"_format": "json"})
     * @Method({"GEt"})
     */
    public function getUsernameAction() {
        /* @var $sc \Symfony\Component\Security\Core\SecurityContext */
        $sc = $this->get('security.context');

        return new Response($sc->getToken()->getUsername());
    }
}
