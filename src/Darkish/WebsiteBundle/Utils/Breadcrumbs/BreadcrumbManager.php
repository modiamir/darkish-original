<?php


namespace Darkish\WebsiteBundle\Utils\Breadcrumbs;


use Symfony\Component\DependencyInjection\Container;
use Darkish\CategoryBundle\Entity\Record;
use Darkish\WebsiteBundle\Entity\WebMainTree;




class BreadcrumbManager
{
    private $container;
    private $bread;
    private $router;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->bread = $this->container->get('white_october_breadcrumbs');
        $this->router = $this->container->get('router');
    }

    public function createBreadcrumb($controller, $routeName, $entity = null) {

        $ptn = "/_[a-z]?/";
        $capitalRouteName = preg_replace_callback($ptn, function ($matches) {
            return strtoupper(ltrim($matches[0], "_"));
        }, $routeName);

        $arr = explode('\\', $controller);
        $controllerClassName = end($arr);
        $creatorClass  = 'Darkish\\WebsiteBundle\\Utils\\Breadcrumbs\\'.$controllerClassName.'Breadcrumbs';
        $creatorMethod = $capitalRouteName.'Builder';

        $r = new \ReflectionClass($creatorClass);
        $creator = $r->newInstanceArgs([$this->container]);

        if($entity)
        {
            $creator->$creatorMethod($entity);
        } else
        {
            $creator->$creatorMethod();
        }



    }

}

