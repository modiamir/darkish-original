<?php

namespace Darkish\CategoryBundle\Interfaces;

use Darkish\CategoryBundle\Entity\ClassifiedClaimTypes;

interface ClaimableInterface
{
    public function setClaimType($claimType = null);

    public function getClaimType();
}