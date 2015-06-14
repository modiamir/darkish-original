<?php

namespace Darkish\WebsiteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Darkish\CategoryBundle\Entity\RecordRequest;
use Darkish\WebsiteBundle\Form\CustomerPasswordRequestType;
use Darkish\CustomerBundle\Entity\PasswordRequest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * 
 *
 */
class CustomerPasswordRequestController extends Controller
{

    
    
    /**
     * Creates a new PasswordRequest entity.
     *
     * @Route("/", name="password_request_create")
     * @Method("POST")
     * @Template("DarkishWebsiteBundle:CustomerPasswordRequest:index.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PasswordRequest();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity->setCreated(new \DateTime());
            $date = new \DateTime();
            $date->add(new \DateInterval('P7D'));
            $entity->setExpire($date);

            $encoder = $this->get('my_mencryptor');
            
            $encrypted = $encoder->encrypt(hash('sha256',$entity->getEmail().'#'.uniqid()));
            $encrypted = str_replace('/', '1', $encrypted);
            $entity->setCode($encrypted, true);
            $entity->setUsed(false);
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'درخواست شما ثبت گردید. بعد از بررسی با شما تماس گرفته خواهد شد.'
            );
            return $this->redirect($this->generateUrl('password_request'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a PasswordRequest entity.
     *
     * @param PasswordRequest $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PasswordRequest $entity)
    {
        $form = $this->createForm(new CustomerPasswordRequestType(), $entity, array(
            'action' => $this->generateUrl('password_request_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'ارسال'));

        return $form;
    }

    /**
     * Displays a form to create a new PasswordRequest entity.
     *
     * @Route("/", name="password_request")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $entity = new PasswordRequest();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * @Route("/remember/{code}", name="remember_request_code")
     * @Method("GET")
     * @Template()
     */
    public function rememberAction($code) {
        $qb = $this->getDoctrine()->getRepository('DarkishCustomerBundle:PasswordRequest')->createQueryBuilder('pr');
        $qb->where('pr.code = :code')->setParameter('code', $code);
        $qb->andWhere('pr.used = :used')->setParameter('used', false);
        $qb->andWhere('pr.expire > :now')->setParameter('now', new \DateTime() );
        $qb->setMaxResults(1);
        $passwordRequests = $qb->getQuery()->getResult();

        if(count($passwordRequests) <= 0) {
            throw new NotFoundHttpException();
        }

        $passwordRequest = $passwordRequests[0];

        $encrypting = ['code'=>$code, 'id' => $passwordRequest->getId() ];
        $encoder = $this->get('my_mencryptor');
        $encrypted = $encoder->encrypt(json_encode($encrypting));

        $form = $this->createFormBuilder(null,array(
                'action' => $this->generateUrl('password_request_remember'),
                'method' => 'POST',
            ))
            ->add('newPassword', 'repeated', array(
                   'first_name'  => 'password',
                   'second_name' => 'confirm',
                   'type'        => 'password',
                   'first_options'       => ['label' =>'رمز عبور'],
                   'second_options'       => ['label' =>'تایید رمز عبور']
                ))
            ->add('data', 'hidden', array(
                'data' => $encrypted,
            ))
            ->add('save', 'submit', array('label' => 'ارسال'))
            ->getForm();


        return array(
            'form'   => $form->createView(),
        );


    }

    /**
     * @Route("/request/remember/", name="password_request_remember")
     * @Method("POST")
     * @Template()
     */
    public function requestRememberAction(Request $request) {
        $form = $this->createFormBuilder(null,array(
                'action' => $this->generateUrl('password_request_remember'),
                'method' => 'POST',
            ))
            ->add('newPassword', 'repeated', array(
                   'first_name'  => 'password',
                   'second_name' => 'confirm',
                   'type'        => 'password',
                   'first_options'       => ['label' =>'رمز عبور'],
                   'second_options'       => ['label' =>'تایید رمز عبور']
                ))
            ->add('data', 'hidden')
            ->add('save', 'submit', array('label' => 'ارسال'))
            ->getForm();

        $form->handleRequest($request);
        $encrypted = $form->get('data')->getData();
        $encryptor = $this->get('my_mencryptor');
        $data = json_decode($encryptor->decrypt($encrypted));
        if($form->isValid()) {
            $qb = $this->getDoctrine()->getRepository('DarkishCustomerBundle:PasswordRequest')->createQueryBuilder('pr');
            $qb->where('pr.code = :code')->setParameter('code', $data->code);
            $qb->andWhere('pr.used = :used')->setParameter('used', false);
            $qb->andWhere('pr.expire > :now')->setParameter('now', new \DateTime());
            $qb->andWhere('pr.id = :id')->setParameter('id', $data->id);
            $passwordRequests = $qb->getQuery()->getResult();

            if(count($passwordRequests) <= 0) {
                $this->get('session')->getFlashBag()->add(
                    'danger',
                    'رمز عبور معتبر نیست.'
                );
                return $this->redirect($this->generateUrl('remember_request_code', ['code' => $data->code]));
            }

            $passwordRequest = $passwordRequests[0];

            $customer = $this->getDoctrine()->getRepository('DarkishCustomerBundle:Customer')
                                ->findOneBy(['username' => $passwordRequest->getEmail()]);
            if(!($customer instanceof \Darkish\CustomerBundle\Entity\Customer)) {
                $this->get('session')->getFlashBag()->add(
                    'danger',
                    'رمز عبور معتبر نیست.'
                );
                return $this->redirect($this->generateUrl('remember_request_code', ['code' => $data->code]));
            }
            $customer->setNewPassword($form->get('newPassword')->getData());
            $passwordRequest->setUsed(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->persist($passwordRequest);
            $em->flush();
            return $this->redirect($this->generateUrl('password_remember_done'));
        } else {
            $this->get('session')->getFlashBag()->add(
                'danger',
                'رمز عبور معتبر نیست.'
            );
            return $this->redirect($this->generateUrl('remember_request_code', ['code' => $data->code]));
        }
    }

    /**
     * @Route("done", name="password_remember_done")
     * @Template
     */
    public function passwordRememberDoneAction() {

    }
}
