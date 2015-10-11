<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;


/**
 * ClientItinerary
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ClientItinerary extends Itinerary
{
    /**
     * @ORM\ManyToOne(targetEntity="Darkish\UserBundle\Entity\Client")
     * @Groups({"itinerary.list.api"})
     */
    private $owner;



    /**
     * Set owner
     *
     * @param \Darkish\UserBundle\Entity\Client $owner
     *
     * @return ClientItinerary
     */
    public function setOwner(\Darkish\UserBundle\Entity\Client $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Darkish\UserBundle\Entity\Client
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set claimType
     *
     * @param integer $claimType
     *
     * @return ClientItinerary
     */
    public function setClaimType($claimType = null)
    {
        $this->claimType = $claimType;

        return $this;
    }

    /**
     * Get claimType
     *
     * @return integer
     */
    public function getClaimType()
    {
        return $this->claimType;
    }
}
