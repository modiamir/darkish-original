<?php

namespace Darkish\CategoryBundle\Interfaces;

interface VisitableInterface
{
    public function setVisitCount($visitCount);
    public function getVisitCount();
}