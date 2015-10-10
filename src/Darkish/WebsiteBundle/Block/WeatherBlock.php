<?php

namespace Darkish\WebsiteBundle\Block;

use Darkish\CommentBundle\Entity\AnonymousComment;
use Darkish\WebsiteBundle\Form\CommentType;
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
class WeatherBlock extends BaseBlockService
{
	private $container;
	
	public function __construct($first, $second, Container $container) {
		parent::__construct($first, $second);
		$this->container= $container;
	}

	public function setDefaultSettings(OptionsResolverInterface $resolver)
	{
	    $resolver->setDefaults(array(
	        'template' => 'DarkishWebsiteBundle:Block:weather.html.twig',
	    ));
	}



    public function getStylesheets($media) {
        return array(
            $this->container->get('templating.helper.assets')->getUrl('bundles/darkishwebsite/stylesheets/weather.css'),
        );
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


        $weather = file_get_contents($this->container->get('kernel')->getRootDir().'/Resources/data/weather.json');

        $weather = $this->container->get('jms_serializer')->deserialize($weather, 'array', 'json');


        $weatherStatus = file_get_contents($this->container->get('kernel')->getRootDir().'/Resources/data/weather_status.json');

        $weatherStatus = $this->container->get('jms_serializer')->deserialize($weatherStatus, 'array', 'json');

        $dayTrans = [
            'Sat' => 'شنبه',
            'Sun' => 'یکشنبه',
            'Mon' => 'دوشنبه',
            'Tue' => 'سه شنبه',
            'Wed' => 'چهار شنبه',
            'Thu' => 'پنج شنبه',
            'Fri' => 'جمعه',
        ];

	    return $this->renderResponse($blockContext->getTemplate(), array(
			'block'     	=> $blockContext->getBlock(),
			'settings'  	=> $settings,
			'weather'	=> $weather,
            'weather_status' => $weatherStatus,
            'day_trans' => $dayTrans
		), $response);
	}


}

