<?php

namespace Darkish\WebsiteBundle\Block;

use Darkish\CategoryBundle\Entity\Estate;
use Darkish\CommentBundle\Entity\AnonymousComment;
use Darkish\WebsiteBundle\Form\CommentType;
use Darkish\WebsiteBundle\Form\EstateSearchType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockServiceInterface;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Acl\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;


/**
* 
*/
class DatabaseBlock extends BaseBlockService
{
	private $container;
	
	public function __construct($first, $second, Container $container) {
		parent::__construct($first, $second);
		$this->container= $container;
	}

	public function setDefaultSettings(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'id'    => null,
	        'template' => 'DarkishWebsiteBundle:Block:database_list.html.twig',
	    ));
	}

	
	public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        throw new \Exception();
    }

    public function validateBlock(ErrorElement $errorElement, BlockInterface $block)
    {
        throw new \Exception();
    }

	public function execute(BlockContextInterface $blockContext, Response $response = null)
	{

		$settings = $blockContext->getSettings();

		$record = $this->container->get('doctrine')
						->getRepository('DarkishCategoryBundle:Record')
						->find($settings['id']);

		if(!$record) {
			throw new \Exception('Record id is invalid.');
		}

		// finding thread based on entity_type and id
//		switch($settings['entity_type']) {
//
//			case "record":
//				$entity= $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Record')->find($settings['id']);
//				if(!$entity) {
//					throw new Exception("Id is not valid");
//				}
//				$thread = $entity->getThread();
//				break;
//			case "news":
//				$entity= $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Record')->find($settings['id']);
//				if(!$entity) {
//					throw new Exception("Id is not valid");
//				}
//				$thread = $entity->getThread();
//				break;
//			case "forumtree":
//				break;
//			case "safarsaz":
//				break;
//		}
//
//		if($thread) {
//			$repo = $this->container->get('doctrine')->getRepository('DarkishCommentBundle:Comment');
//			$qb = $repo->createQueryBuilder('c');
//			$qb->where('c.thread = :thid')->setParameter('thid', $thread->getId());
//			$qb->andWhere('c.parent IS NULL');
//			$qb->orderBy('c.id', 'Desc');
//			$pagination = $this->container->get('knp_paginator')->paginate(
//				$qb->getQuery(),
//				$this->container->get('request')->query->getInt('page', 1)/*page number*/,
//				10/*limit per page*/
//			);
//		} else {
//			$pagination = null;
//		}
//


		$dbType = $record->getDbaseTypeIndex();


		if($dbType->getId() == 1) {
			$database = new Estate();
			$form = $this->container->get('form.factory')->create(new EstateSearchType(), $database, [
				'method' => 'GET'
			]);
			$repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Estate');
		} else
		{
			$database = new Estate();
			$form = $this->container->get('form.factory')->create(new EstateSearchType(), $database, [
				'method' => 'GET'
			]);
			$repo = $this->container->get('doctrine')->getRepository('DarkishCategoryBundle:Estate');
		}

		$form->handleRequest($this->container->get('request'));

		$request = $this->container->get('request');

		$prices = [];
		if($request->request->has('priceFrom'))
		{
			$prices['from'] = $request->get('priceFrom');
		}

		if($request->request->has('priceTo'))
		{
			$prices['to'] = $request->get('priceTo');
		}
        /* @var $pagination \Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination */
        $pagination = $this->container->get('knp_paginator')->paginate(
			$repo->search($database, $prices, $record),
			$this->container->get('request')->query->getInt('page', 1),
			5
		);






	    return $this->renderResponse($blockContext->getTemplate(), array(
			'block'     	=> $blockContext->getBlock(),
			'settings'  	=> $settings,
//			'entity'		=> $entity,
			'pagination'	=> $pagination,
			'search_form'   => $form->createView()
		), $response);
	}


}

