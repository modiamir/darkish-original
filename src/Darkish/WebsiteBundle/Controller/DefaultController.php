<?php

namespace Darkish\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Length;
use Darkish\CustomerBundle\Entity\Customer;


class DefaultController extends Controller
{
	/**
	 * @Route("/")
	 */
    public function indexAction()
    {
    	return $this->render('DarkishWebsiteBundle:Default:index.html.twig');
    }

    /**
     * @Route("/register/customer", name="register_customer")
     */
    public function registerCustomerAction(Request $request) {
    	
    	$currentStep = ($request->request->has('data')) ? 2 : 1; 
    	$nextStep = $currentStep;


    	$firstStepForm = $this->createFormBuilder()
	    	->add('recordNumber', 'text', array('label' => 'شماره رکورد','constraints' => new Length(array('min' => 3))))
			->add('username', 'password', array('label' => 'رمز اول'))
			->add('password', 'password', array('label' => 'رمز دوم'))
			->add('captcha', 'captcha')
			->add('save', 'submit', array('label' => 'ارسال'))
			->getForm();
    	
    	$customer = new Customer();
    	$secondStepForm = $this->createFormBuilder($customer)
	    	->add('username', 'email', ['label' => 'پست الکترونیکی'])
            // ->add('newPassword', 'password', ['label' => 'رمز عبور'])
            ->add('newPassword', 'repeated', array(
	               'first_name'  => 'password',
	               'second_name' => 'confirm',
	               'type'        => 'password',
	               'first_options'       => ['label' =>'رمز عبور'],
	               'second_options'       => ['label' =>'تایید رمز عبور']
	            ))
            ->add('phoneOne', 'number', ['label' => 'تلفن اول'])
            ->add('phoneTwo', 'number', ['label' => 'تلفن دوم', 'required'=>false])
            ->add('phoneThree', 'number', ['label' => 'تلفن سوم', 'required'=>false])
            ->add('phoneFour', 'number', ['label' => 'تلفن چهارم', 'required'=>false])
            ->add('fullName', 'text', ['label' => 'نام و نام خانوادگی'])
            ->add('save', 'submit', array('label' => 'ارسال'))
			->getForm();

    	
    	if($currentStep == 1) {
    		
    		$firstStepForm->handleRequest($request);
			if ($firstStepForm->isValid()) {
				$data = $firstStepForm->getData();
				$repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:RecordRegisterCode');
				$codes = $repo->findBy([
					'recordNumber' => $data['recordNumber'],
					'used' => false
				]);
				
				if(count($codes) == 1) {
					if($codes[0]->getUsername() != $firstStepForm->get('username')->getData() ||
						$codes[0]->getPassword() != $firstStepForm->get('password')->getData()) {
							$this->get('session')->getFlashBag()->add(
					            'danger',
					            'رمز های وارد شده صحیح نمیباشد'
					        );
					} else {
						$records = $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')
							->findBy(['recordNumber' => $data['recordNumber']]);
						if(count($records) <= 0) {
							$this->get('session')->getFlashBag()->add(
					            'danger',
					            'هنوز برای واحد شما رکوردی ایجاد نشده است. لطفا در روزهای آینده برای ثبت نام دوباره اقدام فرمایید.'
					        );
					        return $this->redirect($this->generateUrl('register_customer'));

						}
						$this->get('session')->getFlashBag()->add(
				            'success',
				            'رمز های وارد شده صحیح است. اطلاعات تکمیلی جهت ثبت نام را وارد نمایید.'
				        );
				        $date =  date('Y-m-d H:i:s', strtotime('+10 minutes'));
				        $encrypting = ['codeId'=>$codes[0]->getId(), 'expire' => $date, 'recordNumber' => $codes[0]->getRecordNumber() ];
				        $encoder = $this->get('my_mencryptor');
				        $encrypted = $encoder->encrypt(json_encode($encrypting));
				        $nextStep = 2;
					}
					
				} else {
					$this->get('session')->getFlashBag()->add(
			            'danger',
			            'برای شماره رکورد وارد شده کد ثبت نام فعالی وجود ندارد'
			        );
					
				}
		    }
    	} elseif($currentStep == 2) {

    		$encrypted = $request->get('data');
    		$encryptor = $this->get('my_mencryptor');
    		$data = json_decode($encryptor->decrypt($encrypted));

    		if(!isset($data->codeId) || !isset($data->expire) || !isset($data->recordNumber) || 
    			new \DateTime() < new \DateTime($data->expire) ) {
    			

	    		// $this->get('session')->getFlashBag()->add(
		     //        'warning',
		     //        'نشست شما منقضی شده است. لطفا عملیات ثبت نام را دوباره آغاز کنید'
		     //    );
		     //    return $this->redirect($this->generateUrl('register_customer'));
    		}



    		$repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:RecordRegisterCode');
    		$codes = $repo->findBy([
    			'recordNumber' => $data->recordNumber,
    			'id' => $data->codeId
    		]);
    		if(count($codes) ==1 ) {
    			$code = $codes[0];
    			$records = $repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')
    				->findBy(['recordNumber' => $data->recordNumber]);
				$record = $records[0];
    			$secondStepForm->handleRequest($request);
    			if ($secondStepForm->isValid()) {
    				$repo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record');
    				$records = $repo->findBy([
    					'recordNumber' => $data->recordNumber
    				]);
    				$customer->setType('owner');
    				$customer->setRecord($records[0]);
    				$customer->setCreated(new \DateTime());
    				$customer->setIsActive(true);
    				$em = $this->getDoctrine()->getManager();
    				$em->persist($customer);
    				$code->setUsed(true);
    				$em->persist($code);
    				$record->setCustomerRegisterUsed(true);
    				$em->persist($record);
    				$em->flush();

		    		$this->get('session')->getFlashBag()->add(
			            'success',
			            'ثبت نام شما با موفقیت انجام شد. با کلیک بر روی لینک زیر شما میتوانید وارد پنل خود شوید و علاوه بر تکمیل اطلاعات پروفایل خود بخش های مربوط به واحد خود را مدیریت کنید.'
			        );
			        return $this->redirect($this->generateUrl('register_customer'));
    			}
    			

    		} else {
	    		$this->get('session')->getFlashBag()->add(
		            'warning',
		            'داده های نشست شما نا معتبر میباشد'
		        );
		        return $this->redirect($this->generateUrl('register_customer'));
    		}

    		
    		
    	}

    	

    	if($nextStep == 1 || $nextStep == 2) {
    		$form = ($nextStep == 1) ? $firstStepForm : $secondStepForm;
			$viewData = array(
	    			'form' => $form->createView(),
	    			'currentStep' => $currentStep
				);
			if(isset($encrypted)) {
				$viewData['encrypted'] = $encrypted;
			}

	    	return $this->render(
	    		'DarkishWebsiteBundle:Default:RegisterCustomer/register-customer-form.html.twig'
	    		,$viewData);
	    }

	    if($nextStep == 3)  {
	    	return $this->render('DarkishWebsiteBundle:Default:RegisterCustomer/register-customer-done.html.twig');
	    }
    }
    

}
