<?php

namespace Darkish\WebsiteBundle\Block;

use JMS\Serializer\SerializationContext;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockServiceInterface;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMapping;



/**
* 
*/
class SponsorsBlock extends BaseBlockService
{
	private $entityManager;
	private $container;
	public function __construct($first, $second, EntityManager $em, Container $container) {
		parent::__construct($first, $second);
		$this->entityManager = $em;
        $this->container = $container;

	}

	public function setDefaultSettings(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
            'template' => 'DarkishWebsiteBundle:Block:sponsors.html.twig',
            'mode' => 'random',
            'tree_index' => '',
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


        $sponsosJson = file_get_contents($this->container->get('kernel')->getRootDir().'/Resources/data/sponsors.json');
        $sponsorsArr = $this->container->get('jms_serializer')->deserialize($sponsosJson, 'array', 'json');

	    if($settings['mode'] == 'random') {



            $sponsors = [];
            foreach($sponsorsArr as $sponsorList) {
                $sponsors = array_merge($sponsors, $sponsorList);

            }
            shuffle($sponsors);





        } else  {
            $sponsors = $sponsorsArr[$settings['tree_index']];
            shuffle($sponsors);

            if(count($sponsors) < 3) {
                $otherSponsors = [];
                foreach($sponsorsArr as $treeIndex => $sponsorList) {
                    if($treeIndex != $settings['tree_index'])
                    {
                        $otherSponsors = array_merge($otherSponsors, $sponsorList);
                    }
                }
                shuffle($sponsors);
                $sponsors = array_merge($sponsors, $otherSponsors);
            }
        }

        $sponsors = array_slice($sponsors, 0, 3);


        return $this->renderResponse($blockContext->getTemplate(), array(
	            'sponsors'     => $sponsors,
	            'block'     => $blockContext->getBlock(),
	            'settings'  => $settings
	        ), $response);
	}


}

