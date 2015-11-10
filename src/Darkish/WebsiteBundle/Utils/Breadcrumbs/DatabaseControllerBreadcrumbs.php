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

class DatabaseControllerBreadcrumbs extends AbstractControllerBreadcrumbs
{

    public function websiteRecordDatabaseBuilder($type)
    {

        switch($type)
        {
            case 'automobile':
                $this->bread->prependItem('بانک خودرو');
                break;
            case 'estate':
                $this->bread->prependItem('بانک املاک');
                break;
        }
        $this->bread->prependItem('خانه', $this->router->generate('website_home'));
    }


}