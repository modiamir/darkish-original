<?php

namespace Darkish\CategoryBundle\Interfaces;

use Darkish\UserBundle\Entity\Client;
use Doctrine\Common\Collections\ArrayCollection;

interface CanFavoriteInterface
{
    public function addClientsFavorited(Client $client);
    public function removeClientsFavorited(Client $client);

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getClientsFavorited();

    public function setFavoriteCount($favoriteCount);
    public function getFavoriteCount();
}