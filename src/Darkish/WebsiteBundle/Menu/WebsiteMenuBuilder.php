<?php

namespace Darkish\WebsiteBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerAware;


class WebsiteMenuBuilder extends ContainerAware
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-left');
        $menu->addChild('صفحه اصلی', array('route' => 'website_home'))
        ->setAttribute('icon', 'fa fa-home');;
        $menu->addChild('اخبار', array('route' => 'website_news'))
        ->setAttribute('icon', 'fa fa-newspaper-o');
        // ... add more children

        return $menu;
    }
}
