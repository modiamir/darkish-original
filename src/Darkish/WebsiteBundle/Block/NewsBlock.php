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

/**
* 
*/
class NewsBlock extends BaseBlockService
{
	private $entityManager;
	
	public function __construct($first, $second, EntityManager $em) {
		parent::__construct($first, $second);
		$this->entityManager = $em;

	}

	public function setDefaultSettings(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'count'      => 10,
	        'title'    => 'لیست اخبار',
	        'template' => 'DarkishWebsiteBundle:Block:block_news_list.html.twig',
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

	    $repo = $this->entityManager->getRepository('DarkishCategoryBundle:News');
	    $qb = $repo->createQueryBuilder('n');

	    $qb->setMaxResults($settings['count']);
	    $qb->orderBy('n.lastUpdate', 'Desc');

	    $newsList = $qb->getQuery()->getResult();

	    return $this->renderResponse($blockContext->getTemplate(), array(
	            'newsList'     => $newsList,
	            'block'     => $blockContext->getBlock(),
	            'settings'  => $settings
	        ), $response);
	}


}

