<?php

namespace Darkish\CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Darkish\CustomerBundle\Entity\Customer;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Darkish\CustomerBundle\Form\CustomerType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;


class ManageCustomerController extends Controller
{
    
    /**
     * @Route("/admin/customer/manage", name="manage_customer")
     */
    public function manageAction() 
    {
        $user = $this->get('security.context')->getToken()->getUser();
        if(!$user->routeAccess('customer')) {
            throw new AccessDeniedException('Unauthorised access!');
        }
        return $this->render('DarkishCustomerBundle:ManageCustomer:index.html.php');
    }
    
    /**
     * @Route(
     *      "/admin/customer/ajax/get_customers", 
     *      defaults={"_format": "json"}
     * )
     */
    public function getCustomersAction() {
        $repo = $this->getDoctrine()->getRepository('DarkishCustomerBundle:Customer');
        $customers = $repo->findAll();
        return new Response($this->get('jms_serializer')->serialize($customers, 'json', SerializationContext::create()->setGroups(array('customer.list'))));
    }
    
    /**
     * @Route("admin/customer/ajax/search",defaults={"_format": "json"} )
     * @Method({"POST"})
     */
    public function searchCustomerAction(Request $request) {
        $data = $request->request->get('data');
        $recordId = $request->request->get('recordId');
        $repo = $this->getDoctrine()->getRepository('DarkishCustomerBundle:Customer');
        
        /* @var $qb \Doctrine\ORM\QueryBuilder */
        $qb = $repo->createQueryBuilder('o');
        
        if($recordId > 0) {
            $qb->andWhere('o.record = :record')
            ->setParameter('record', $recordId);
        }
        
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
        
        $totalQuery = $qb;
        $totalQuery->andWhere('o.type = :type')->setParameter('type', 'assistant');
        $totalResult = $totalQuery->getQuery()->getResult();
        $totalCount = count($totalResult);
        
        $ownerQuery = $qb;
        $ownerQuery->andWhere('o.type = :type')->setParameter('type', 'owner');
        $owner = $ownerQuery->getQuery()->getResult();
        
        
        $assistantQuery = $qb;
        $assistantQuery->andWhere('o.type = :type')->setParameter('type', 'assistant');
        $assistantQuery->setFirstResult($data['pagination']['start']);
        $assistantQuery->setMaxResults($data['pagination']['number']);
        $assistantResult = $assistantQuery->getQuery()->getResult();
        
        
        
        
        $res = $qb->getQuery()->getResult();
//        $count = count($this->getDoctrine()->getRepository('DarkishCustomerBundle:Customer')->findAll());
        $numOfPages = ceil($totalCount/$data['pagination']['number']);
        $searchRes = array('result' => $assistantResult, 'numOfPages' => $numOfPages, 'assistantCount' => $totalCount, 'owner' => $owner);
        return new Response($this->get('jms_serializer')->serialize($searchRes, 'json', SerializationContext::create()->setGroups(array('customer.list'))));
    }
    
    /**
     * @Route(
     *      "/admin/customer/template/{name}"
     * )
     */
    public function getTemplateAction($name) {
        return $this->render('DarkishCustomerBundle:ManageCustomer:Templates/'.$name.'.php');
    }
    
    /**
     * @Route("/admin/customer/ajax/get_customer/{id}", defaults={"_format": "json"} )
     */
    public function getCustomer($id) {
        try {
            $repo = $this->getDoctrine()->getRepository('DarkishCustomerBundle:Customer');
            $customer = $repo->find($id);
            return new Response($this->get('jms_serializer')->serialize($customer, 'json', SerializationContext::create()->setGroups(array('customer.details')) ));
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        
        
    }

    /**
     * 
     * @param Request $request
     * @return Response
     * @throws Exception
     * @throws UsernameNotFoundException
     * @Route("admin/customer/ajax/login")
     */
    public function ajaxLoginAction(Request $request) {
        try{
            $em = $this->getDoctrine();
            $repo = $em->getRepository("DarkishCustomerBundle:Customer"); //Entity Repository
            $username = ($request->request->has('username'))? $request->request->get('username') : NULL;
            $password = ($request->request->has('password'))? $request->request->get('password') : NULL;
            if(!$username || !$password) {
                throw new \Exception('Username or Password is missing!', 404);
            }
            $users = $repo->findByUsername($username);
            if (count($users) == 0) {
                throw new UsernameNotFoundException("User not found", 404);
            } else {
                $user = $users[0];
                $token = new UsernamePasswordToken($user, null, "admin_area", $user->getRoles());
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                /* @var $factory \Symfony\Component\Security\Core\Encoder\EncoderFactory */
                $isPassValid = $encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt());
                if(!$isPassValid) {
                    throw new \Exception('Password is wrong!', 404);
                }
                if(!$user->getIsActive()) {
                    throw new \Exception('user is disabled!', 403);
                }
                $this->get("security.context")->setToken($token); //now the user is logged in
                $this->setLog('login');
                $event = new InteractiveLoginEvent($request, $token);
                $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
                return new Response('logged in');
            }
        } catch(\Exception $ex) {
            return new Response($ex->getMessage(), 404);
        }
        
        
    }

    /**
     * @Route("/admin/customer/login", name="login_route")
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
     * @Route("/admin/customer/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }
    
    /**
     * @Route("/admin/customer/ajax/logout", name="logout")
     */
    public function ajaxLogoutAction()
    {
        $this->setLog('logout');
        
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        return new Response('logged out');
    }
    
    /**
     * 
     * @return JsonResponse
     * @Route("admin/customer/ajax/is_logged_in")
     */
    public function isLoggedInAction() {
        $securityContext = $this->container->get('security.context');
        /* @var $securityContext \Symfony\Component\Security\Core\SecurityContext */
        $res = $securityContext->getToken()->isAuthenticated();
        

        
        
        return new JsonResponse(array(
                $this->get('security.context')->isGranted(
                    'ROLE_USER'
                   ))
        );
    }
    
    /**
     * @Route("/admin/customer/check_permission", name="check_permission")
     */
    public function checkPermissionAction() {
        $record = new \Darkish\CategoryBundle\Entity\Record();
        return new JsonResponse($this->get('security.context')->isGranted('edit', $record));
        
        
    }
    
    /**
     * 
     * @Route("admin/customer/ajax/create",defaults={"_format": "json"} )
     * @Method({"POST"})
     */
    public function createAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $customer = new Customer();
//        return new Response($this->get('jms_serializer')->serialize($request->request, 'json'));
        $form = $this->createForm(new CustomerType, $customer);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $em->persist($customer);
            $em->flush();
            return new Response($this->get('jms_serializer')->serialize($customer, 'json', SerializationContext::create()->setGroups(array('customer.details'))));
        }
        return new Response($form->getErrorsAsString(), 500);
    }
    
    
    /**
     * 
     * @Route("admin/customer/ajax/update/{id}",defaults={"_format": "json"} )
     * @Method({"POST"})
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $customer = $em->getRepository('DarkishCustomerBundle:Customer')->find($id);
//        return new Response($this->get('jms_serializer')->serialize($request->request, 'json'));
        $form = $this->createForm(new CustomerType, $customer);
        
        $form->handleRequest($request);
        if ($form->isValid()) {
            // perform some action, such as saving the task to the database
            $em->flush();
            return new Response($this->get('jms_serializer')->serialize($customer, 'json', SerializationContext::create()->setGroups(array('customer.details'))));
        }
        return new Response($form->getErrorsAsString(), 500);
    }
    
    /**
     * 
     * @Route("admin/customer/ajax/delete_customer", defaults={"_format": "json"})
     * @Method({"POST"})
     */
    public function deleteAction(Request $request) {
        try {
            
            if (!$request->request->has('id')) {
                throw new Exception('You should send an id to delete', 404);
            }
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $customer = $em->getRepository('DarkishCustomerBundle:Customer')->find($id);
            if(!$customer) {
                throw new Exception('Invalid customer id', '404');
            }
            $em->remove($customer);
            $em->flush();
            return new Response('removed');
            
        } catch (Exception $exc) {
            return new Response($exc->getTraceAsString());
        }

    }
    
    
    /**
     * @Route("admin/customer/ajax/toggle_is_active", defaults={"_format":"json"})
     * @Method({"POST"})
     */
    public function toggleIsActiveAction(Request $request) {
        try {
            
            if (!$request->request->has('id')) {
                throw new Exception('You should send an id to toggle active state', 404);
            }
            $id = $request->request->get('id');
            $em = $this->getDoctrine()->getManager();
            $customer = $em->getRepository('DarkishCustomerBundle:Customer')->find($id);
            if(!$customer) {
                throw new Exception('Invalid customer id', '404');
            }
            /* @var $customer Customer */
            $customer->setIsActive(($customer->getIsActive())? false : true);
            $em->persist($customer);
            $em->flush();
            return new Response('toggled');
            
        } catch (Exception $exc) {
            return new Response($exc->getTraceAsString());
        }
    }
    
    /**
     * @Route("admin/customer/ajax/get_roles", defaults={"_format": "json"})
     * @Method({"GEt"})
     */
    public function getRolesAction() {
        $em = $this->getDoctrine()->getManager();
        $roles = $em->getRepository('DarkishCustomerBundle:CustomerRole')->findAll();
        return new Response($this->get('jms_serializer')->serialize($roles, 'json',SerializationContext::create()->setGroups(array('role.list'))));
    }
    
    /**
     * 
     * @Route("admin/customer/ajax/get_username", defaults={"_format": "json"})
     * @Method({"GEt"})
     */
    public function getUsernameAction() {
        /* @var $sc \Symfony\Component\Security\Core\SecurityContext */
        $sc = $this->get('security.context');

        return new Response($sc->getToken()->getUsername());
    }
    
    public function setLog($operation) {
        $customerLog = new UserLog();
        $customerLog->setDate(new \DateTime());
        $customerLog->setOperation($operation);
        $customer = $this->get('security.context')->getToken()->getUser();
        $customerLog->setCustomer($customer);
        $em = $this->getDoctrine()->getManager();
        $em->persist($customerLog);
        $em->flush();
    }
    
    /**
     * @Route("admin/customer/ajax/find_records/{field}/{value}", defaults={"_format": "json"})
     */
    public function findRecordsByFieldAction($field, $value) {
        $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
        
        $qb = $repo->createQueryBuilder('r');
        $qb->where($qb->expr()->like('r.'.$field, $qb->expr()->literal('%' . $value . '%')));
        $qb->orderBy('r.'.$field, 'ASC');
        $qb->setMaxResults(100);
        $res = $qb->getQuery()->getResult();
        return new Response($this->get('jms_serializer')->serialize(array('results' => $res), 'json', SerializationContext::create()->setGroups(array('record.list'))));
    }
}
