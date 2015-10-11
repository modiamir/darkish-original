<?php

namespace Darkish\CategoryBundle\Interfaces;

interface LikableInterface
{
    public function setLikeCount($likeCount);
    public function getLikeCount();
}