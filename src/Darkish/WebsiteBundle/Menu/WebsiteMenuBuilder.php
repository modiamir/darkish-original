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
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right menu-primary');
        $menu->addChild('درباره جزیره', array('route' => 'website_home'));
        $menu->addChild('سفر و زندگی در کیش', array('route' => 'website_home'));
        $menu->addChild('اماکن گردشگری', array('route' => 'website_home'));
        $menu->addChild('تفریحات کیش', array('route' => 'website_home'));
        $menu->addChild('جشنواره ها', array('route' => 'website_home'));
        $menu->addChild('فرصت های سرمایه گذاری', array('route' => 'website_home'));

        return $menu;
    }

    public function createSecondaryMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav menu-socndary');
        $menu->addChild('اطلاعیه های جزیره', array('route' => 'website_home'));
        $menu->addChild('اخبار جزیره', array('route' => 'website_home'));
        $menu->addChild('گالری تصویری', array('route' => 'website_home'));
        $menu->addChild('تالار گفتگو', array('route' => 'website_home'));
        $menu->addChild('پیشنهاد ویژه', array('route' => 'website_home'));
        $menu->addChild('نیازمندی های جزیره(رایگان)', array('route' => 'website_home'));
        $menu->addChild('ثبت مشاغل', array('route' => 'website_home'));



        return $menu;
    }

    public function createThirdMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav menu-third');
        $menu->addChild('هتل ها', array('route' => 'website_home'));
        $menu->addChild('مراکز تجاری', array('route' => 'website_home'));
        $menu->addChild('رستوران ها', array('route' => 'website_home'));
        $menu->addChild('آژانس های مسافرتی', array('route' => 'website_home'));
        $menu->addChild('مراکز خدماتی', array('route' => 'website_home'));
        $menu->addChild('نیاز های روزانه', array('route' => 'website_home'));
        $menu->addChild('املاک', array('route' => 'website_home'));
        $menu->addChild('خودرو', array('route' => 'website_home'));
        $menu->addChild('مراکز بهداشتی درمانی', array('route' => 'website_home'));
        $menu->addChild('مراکز فرهنگی و آموزشی', array('route' => 'website_home'));
        // ... add more children

        return $menu;
    }
}
