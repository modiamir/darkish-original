<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientItinerary
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class AnonymousItinerary extends Itinerary
{
    /**
     * @ORM\ManyToOne(targetEntity="Darkish\UserBundle\Entity\Anonymous")
     */
    private $owner;


    /**
     * Set owner
     *
     * @param \Darkish\UserBundle\Entity\Anonymous $owner
     *
     * @return AnonymousItinerary
     */
    public function setOwner(\Darkish\UserBundle\Entity\Anonymous $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Darkish\UserBundle\Entity\Anonymous
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
     * @return AnonymousItinerary
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
