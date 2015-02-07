<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * OfferLock
 *
 * @ORM\Table(name="offer_lock")
 * @ORM\Entity
 */
class OfferLock
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
     * @ORM\Column(name="offer_number", type="string", length=255, nullable=false)
     * 
     */
    private $offerNumber;

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
     * @return OfferLock
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
     * Set offerNumber
     *
     * @param string $offerNumber
     * @return OfferLock
     */
    public function setOfferNumber($offerNumber)
    {
        $this->offerNumber = $offerNumber;

        return $this;
    }

    /**
     * Get offerNumber
     *
     * @return string 
     */
    public function getOfferNumber()
    {
        return $this->offerNumber;
    }

    /**
     * Set expire
     *
     * @param \DateTime $expire
     * @return OfferLock
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
     * @return OfferLock
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
