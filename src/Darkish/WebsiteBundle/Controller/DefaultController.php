<?php

namespace Darkish\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;
use Symfony\Component\Validator\Constraints\Length;
use Darkish\CustomerBundle\Entity\Customer;
use Faker;

/**
 * @Route("/", host="%domain%")
 */
class DefaultController extends Controller
{
	/**
	 * @Route("/", name="website_home", host="%domain%")
	 */
    public function indexAction()
    {
        $params = $this->container->getParameter('darkish.front_page');
        $festivals = [];
        foreach($params['kish_festival']['record_numbers'] as $festivalNumber) {
            $festivals[] = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')
                ->findOneBy(['recordNumber' => $festivalNumber]);
        }

        $webMainTrees = [];
        foreach($params['kish_jobs']['trees'] as $treeIndex)
        {
            $webMainTree = $this->getDoctrine()->getRepository('DarkishWebsiteBundle:WebMainTree')
                ->findOneBy(['treeIndex' => $treeIndex]);
            if($webMainTree)
            {
                $webMainTrees[] = $webMainTree;
            }

        }

        $sponsorsQb = $this->getDoctrine()->getRepository('DarkishCategoryBundle:Sponsor')
            ->createQueryBuilder('s');

        $sponsorsQb->join('s.sponsortrees', 'st', 'WITH')
            ->join('st.tree','t', 'WITH',$sponsorsQb->expr()->in('t.id', [1]))
            ->distinct()->setMaxResults(3);

        $sponsors = $sponsorsQb->getQuery()->getResult();

        // News Section
        $newsTreeRepo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:NewsTree');
        $kishNewsTree = $newsTreeRepo->findOneBy(['treeIndex' => "02"]);
        $announcementNewsTree = $newsTreeRepo->findOneBy(['treeIndex' => "01"]);

        $newsRepo = $this->getDoctrine()->getRepository('DarkishCategoryBundle:News');

        $kishNews = $newsRepo->getNewsForCat($kishNewsTree)->setMaxResults(3)->getQuery()->getResult();
        $announcementNews = $newsRepo->getNewsForCat($announcementNewsTree)->setMaxResults(3)->getQuery()->getResult();



    	return $this->render('DarkishWebsiteBundle:Default:index.html.twig', [
            'params' => $params,
            'festivals' => $festivals,
            'webmaintrees' => $webMainTrees,
            'sponsors' => $sponsors,
            'latest_news' => [
                'kish_news' => $kishNews,
                'announcement_news' => $announcementNews
            ]
        ]);
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
						$record = $records[0];
						if($record->getAccessClass()->getId() == 1)
						{
							$this->get('session')->getFlashBag()->add(
								'danger',
								'رکورد مربوطه شما دارای دسترسی مورد نظر جهت ثبت مشتری نمیباشد.'
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




    /**
     * @Route("entity/generator")
     */
    public function generateEntity() {
        $str = '';
        $generator = Faker\Factory::create('fa_IR');
        $populator = new Faker\ORM\Doctrine\Populator($generator,$this->getDoctrine()->getManager());
        $populator->addEntity('\Darkish\CategoryBundle\Entity\Offer', 10,[
            'title' => $generator->realText(50),
            'subTitle' => $generator->realText(100),
            'publishDate' => $generator->dateTimeBetween('-30 days'),
            'expireDate' => $generator->dateTimeBetween('now', '+30 days'),
            'body' => $generator->realText(1000),
            'webBody' => null,
            'website' => $generator->url,
            'active' => true,
            'verify' => true,
            'offertrees' => function($entity) use ($generator) {
//                $trees = $generator->randomElements(['4','5','6','7','8','9','10','13','14','15','16','18','19','24','25','26','28','29','30','31','32','36','39','41','43','44','45','53','54','56','58','62','73','74','75','76','78','79','80','81','83','84','85','86','92','103','111','114','115','116','117','118','119','120','121','122','123','124','125'], 1);
                $trees = $generator->randomElements([1,2,3,4,5,6,7,8,9,10,11,12], 1);
                $offertrees= new ArrayCollection();

                $offertree = new OfferOfferTree();
                $offertree->setTree($this->getDoctrine()->getRepository('DarkishCategoryBundle:OfferTree')->find($trees[0]));

                $offertrees->add($offertree);

                return $offertrees;

            }

        ],[
            function($offer){
                $iterator = $offer->getOffertrees()->getIterator();

                while($iterator->valid()) {
                    $cur = $iterator->current();
                    $cur->setOffer($offer);
                    $iterator->next();
                }
            }
        ]);
        $insertedPKs = $populator->execute();
        return new Response($this->get('jms_serializer')->serialize($insertedPKs, 'json', SerializationContext::create()->setGroups(["offer.details"])));
    }




}
