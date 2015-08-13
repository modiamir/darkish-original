<?php

namespace Darkish\WebsiteBundle\Twig\Extension;

use Symfony\Component\DependencyInjection\Container;

class ClassExtension extends \Twig_Extension
{
    private $container;
    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'class_extension';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('obj_class', array($this, 'getClass')),
        );
    }

    public function getClass($object)
    {
        return (new \ReflectionClass($object))->getShortName();
    }
}
