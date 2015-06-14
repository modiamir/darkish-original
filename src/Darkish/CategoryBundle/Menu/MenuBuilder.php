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
            'sponsor' => 'اسپانسر',
            'classified' => 'نیازمندی ها',
            'operator' => 'اپراتور ها',
            'manage_customer' => 'مدیریت مشتری ها',
            'forum' => 'مدیریت نظرات',
        );

    }

    public function createMainMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root')->setChildrenAttributes(array('class'=>'dropdown-menu'));

        // ... add more children
        $al = $this->securityContext->getToken()->getUser()->getAccessLevel();
        
        
        $request = $this->container->get('request');
        $currentRouteName = $request->get('_route');
        
        foreach($this->routes as $routeName => $value) {
            $this->addChild($menu, $routeName, $currentRouteName);
        }
        
        
        return $menu;
    }
    
    private function addChild(&$menu, $routeName, $currentRouteName) {
        $operator = $this->securityContext->getToken()->getUser();
        if($operator->routeAccess($routeName) && $routeName != $currentRouteName) {
            $menu->addChild($this->routes[$routeName], array('route' => $routeName));
        }
    }
}