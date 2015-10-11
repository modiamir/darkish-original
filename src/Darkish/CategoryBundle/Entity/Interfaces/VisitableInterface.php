<?php

namespace Darkish\CategoryBundle\Entity\Interfaces;

interface VisitableInterface
{
    public function setVisitCount($visitCount);
    public function getVisitCount();
}