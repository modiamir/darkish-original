<?php

namespace Darkish\WebsiteBundle\Twig\Extension;

use Darkish\CustomerBundle\Entity\Customer;
use Darkish\UserBundle\Entity\Anonymous;
use Darkish\UserBundle\Entity\Client;
use Darkish\UserBundle\Entity\Operator;
use Symfony\Component\DependencyInjection\Container;

class UserExtension extends \Twig_Extension
{
    private $container;
    public function __construct(Container $container) {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_extension';
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('user_name', array($this, 'userName')),
            new \Twig_SimpleFilter('user_photo', array($this, 'userPhoto')),
        );
    }

    public function userName($user) {
        if($user instanceof Operator) {
            if($user->getFirstName() || $user->getLastName())
            {
                return $user->getFirstName().' '.$user->getLastName();
            } else {
                return $user->getUsername();
            }

        } elseif($user instanceof Customer) {
            return $user->getFullName();
        } elseif($user instanceof Client) {
            return ($user->getFullName())?$user->getFullName():$user->getUsername();
        } elseif($user instanceof Anonymous) {
            return $user->getFullName();
        } else {
            return "";
        }

    }

    public function userPhoto($user) {
        if($user instanceof Operator) {
            return ($user->getPhoto()) ? $user->getPhoto()->getIconAbsolutePath() : null;
        } elseif($user instanceof Customer) {
            return ($user->getPhoto()) ? $user->getPhoto()->getIconAbsolutePath() : null;
        } elseif($user instanceof Client) {
            return ($user->getPhoto()) ? $user->getPhoto()->getIconAbsolutePath() : null;
        } else {
            return null;
        }
    }

}
