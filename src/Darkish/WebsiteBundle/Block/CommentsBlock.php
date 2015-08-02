<?php

namespace Darkish\WebsiteBundle\Block;

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
class CommentsBlock extends BaseBlockService
{
	private $container;
	
	public function __construct($first, $second, Container $container) {
		parent::__construct($first, $second);
		$this->container= $container;
	}

	public function setDefaultSettings(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'entity_type'      => null,
	        'id'    => null,
	        'template' => 'DarkishWebsiteBundle:Comment:comment_list.html.twig',
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


		// finding thread based on entity_type and id
		switch($settings['entity_type']) {
			case "record":
				$entity= $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->find($settings['id']);
				if(!$entity) {
					throw new Exception("Id is not valid");
				}
				$thread = $entity->getThread();
				break;
			case "news":
				$entity= $this->getDoctrine()->getRepository('DarkishCategoryBundle:Record')->find($settings['id']);
				if(!$entity) {
					throw new Exception("Id is not valid");
				}
				$thread = $entity->getThread();
				break;
			case "forumtree":
				break;
			case "safarsaz":
				break;
		}

		$repo = $this->container->get('doctrine')->getRepository('DarkishCommentBundle:Comment');
		$qb = $repo->createQueryBuilder('c');
		$qb->where('c.thread = :thid')->setParameter('thid', $thread->getId());
		$qb->orderBy('c.id', 'Desc');
		$pagination = $this->container->get('knp_paginator')->paginate(
			$qb->getQuery(),
			$this->container->get('request')->query->getInt('page', 1)/*page number*/,
			10/*limit per page*/
		);


	    return $this->renderResponse($blockContext->getTemplate(), array(
	            'block'     => $blockContext->getBlock(),
	            'settings'  => $settings
	        ), $response);
	}


}

