<?php
// src/AppBundle/Menu/MenuBuilder.php

namespace Darkish\CategoryBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MenuBuilder
{
    private $factory;
    private $securityContext;
    protected $container;
    private $routes;
    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, SecurityContextInterface $securityContext,
            ContainerInterface $container)
    {
        $this->factory = $factory;
        $this->securityContext = $securityContext;
        $this->container = $container;
        $this->routes = array(
            'record' => 'رکورد',
            'news' => 'اخبار و سرگرمی',
            'offer' => 'پیشنهاد ویژه',
            'classified' => 'نیازمندی ها',
            'operator' => 'اپراتور ها',
//            'forum' => 'تالار گفتگو',
        );

    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root')->setChildrenAttributes(array('class'=>'dropdown-menu'));

        // ... add more children
        $al = $this->securityContext->getToken()->getUser()->getAccessLevel();
        
        $al = json_decode($al);
        
        $request = $this->container->get('request');
        $currentRouteName = $request->get('_route');
        
        foreach($this->routes as $routeName => $value) {
            $this->addChild($menu, $routeName, $al, $currentRouteName);
        }
        
        
        return $menu;
    }
    
    private function addChild($menu, $routeName, $al, $currentRouteName) {
        if(in_array($routeName, $al) && $routeName != $currentRouteName) {
            $menu->addChild($this->routes[$routeName], array('route' => $routeName));
        }
    }
}