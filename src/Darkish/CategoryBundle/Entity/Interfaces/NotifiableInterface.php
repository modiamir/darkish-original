<?php

namespace Darkish\CategoryBundle\Entity\Interfaces;

interface NotifiableInterface
{
    /**
     * @param boolean $notify
     */
    public function setNotify( $notify);
    public function getNotify();
}