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
        $menu->addChild('درباره جزیره', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0000"
            ]
        ));
        $menu->addChild('سفر و زندگی در کیش', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0014"
            ]
        ));
        $menu->addChild('اماکن گردشگری', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "000005"
            ]
        ));
        $menu->addChild('تفریحات کیش', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0003"
            ]
        ));
        $menu->addChild('جشنواره ها', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "001313"
            ]
        ));
        $menu->addChild('فرصت های سرمایه گذاری', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0012"
            ]
        ));

        return $menu;
    }

    public function createSecondaryMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav menu-socndary');

        $menu->addChild('اطلاعیه های جزیره', array(
            'route' => 'website_home',
            'routeParameters' => [
                'treeIndex' => ""
            ]
        ));

        $menu->addChild('اخبار جزیره', array(
            'route' => 'website_news',
        ));

        $menu->addChild('گالری تصویری', array(
            'route' => 'website_home',
            'routeParameters' => [
                'treeIndex' => ""
            ]
        ));

        $menu->addChild('تالار گفتگو', array(
            'route' => 'website_forum',
        ));

        $menu->addChild('سفرنامه', array(
            'route' => 'website_itinerary',
        ));

        $menu->addChild('پیشنهاد ویژه', array(
            'route' => 'website_offer',
        ));

        $menu->addChild('نیازمندی های جزیره(رایگان)', array(
            'route' => 'website_classified',
        ));

        $menu->addChild('ثبت مشاغل', array(
            'route' => 'website_home',
            'routeParameters' => [
                'treeIndex' => ""
            ]
        ));



        return $menu;
    }

    public function createThirdMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav menu-third');
        $menu->addChild('هتل ها', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0005"
            ]
        ));
        $menu->addChild('مراکز تجاری', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0001"
            ]
        ));
        $menu->addChild('رستوران ها', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0002"
            ]
        ));
        $menu->addChild('آژانس های مسافرتی', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0006"
            ]
        ));
        $menu->addChild('مراکز خدماتی', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0009"
            ]
        ));
        $menu->addChild('نیاز های روزانه', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0004"
            ]
        ));
        $menu->addChild('املاک', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0007"
            ]
        ));
        $menu->addChild('خودرو', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0008"
            ]
        ));
        $menu->addChild('مراکز بهداشتی درمانی', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0010"
            ]
        ));
        $menu->addChild('مراکز فرهنگی و آموزشی', array(
            'route' => 'website_record_tree',
            'routeParameters' => [
                'treeIndex' => "0011"
            ]
        ));
        // ... add more children

        return $menu;
    }
}
