<?php

namespace Darkish\CategoryBundle\Interfaces;

interface NotifiableInterface
{
    /**
     * @param boolean $notify
     */
    public function setNotify( $notify);
    public function getNotify();
}