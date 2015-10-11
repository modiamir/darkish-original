<?php

namespace Darkish\CategoryBundle\Entity\Interfaces;

interface LikableInterface
{
    public function setLikeCount($likeCount);
    public function getLikeCount();
}