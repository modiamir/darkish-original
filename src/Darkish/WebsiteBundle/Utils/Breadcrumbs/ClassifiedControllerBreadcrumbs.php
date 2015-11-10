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

class ClassifiedControllerBreadcrumbs extends AbstractControllerBreadcrumbs
{

    public function websiteClassifiedBuilder()
    {
        $this->bread->prependItem('نیازمندی ها');
        $this->bread->prependItem('خانه', $this->router->generate('website_home'));
    }

    public function websiteClassifiedSubmitBuilder(Classified $classified)
    {
        $this->bread->prependItem($classified->getTitle());
        $this->bread->prependItem('نیازمندی ها', $this->router->generate('website_classified'));
        $this->bread->prependItem('خانه', $this->router->generate('website_home'));

    }
}