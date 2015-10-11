<?php

namespace Darkish\CategoryBundle\Entity\Interfaces;

use Darkish\CategoryBundle\Entity\ClassifiedClaimTypes;

interface ClaimableInterface
{
    public function setClaimType($claimType = null);

    public function getClaimType();
}