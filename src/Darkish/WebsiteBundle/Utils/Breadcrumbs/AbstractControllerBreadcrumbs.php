<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/19/15
 * Time: 6:22 PM
 */

namespace Darkish\WebsiteBundle\Utils\Breadcrumbs;

use Symfony\Component\DependencyInjection\Container;

class AbstractControllerBreadcrumbs
{
    protected $container;
    protected $bread;
    protected $router;

    public function __construct(Container $container) {
        $this->container = $container;
        $this->bread = $this->container->get('white_october_breadcrumbs');
        $this->router = $this->container->get('router');


    }


}