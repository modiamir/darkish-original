<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/19/15
 * Time: 5:50 PM
 */

namespace Darkish\WebsiteBundle\Utils\Breadcrumbs;


use Darkish\CategoryBundle\Entity\Classified;
use Darkish\WebsiteBundle\Entity\WebMainTree;
use Symfony\Component\DependencyInjection\Container;

class CustomerPasswordRequestControllerBreadcrumbs extends AbstractControllerBreadcrumbs
{

    public function passwordRequestCreateBuilder()
    {
        $this->bread->prependItem('باز یابی رمز عبور');
        $this->bread->prependItem('خانه', $this->router->generate('website_home'));
    }


}