<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * SponsorLock
 *
 * @ORM\Table(name="sponsor_lock")
 * @ORM\Entity
 */
class SponsorLock
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="user_id", type="integer", nullable=false)
     */
    private $userId;

    /**
     *
     * @ORM\Column(name="sponsor_number", type="string", length=255, nullable=false)
     * 
     */
    private $sponsorNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expire", type="datetime")
     */
    private $expire;


    

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return SponsorLock
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }




    /**
     * Set sponsorNumber
     *
     * @param string $sponsorNumber
     * @return SponsorLock
     */
    public function setSponsorNumber($sponsorNumber)
    {
        $this->sponsorNumber = $sponsorNumber;

        return $this;
    }

    /**
     * Get sponsorNumber
     *
     * @return string 
     */
    public function getSponsorNumber()
    {
        return $this->sponsorNumber;
    }

    /**
     * Set expire
     *
     * @param \DateTime $expire
     * @return SponsorLock
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * Get expire
     *
     * @return \DateTime 
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return SponsorLock
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
