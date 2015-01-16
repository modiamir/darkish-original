<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * NewsLock
 *
 * @ORM\Table(name="news_lock")
 * @ORM\Entity
 */
class NewsLock
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
     * @ORM\Column(name="news_number", type="string", length=255, nullable=false)
     * 
     */
    private $newsNumber;

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
     * @return NewsLock
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
     * Set newsNumber
     *
     * @param string $newsNumber
     * @return NewsLock
     */
    public function setNewsNumber($newsNumber)
    {
        $this->newsNumber = $newsNumber;

        return $this;
    }

    /**
     * Get newsNumber
     *
     * @return string 
     */
    public function getNewsNumber()
    {
        return $this->newsNumber;
    }

    /**
     * Set expire
     *
     * @param \DateTime $expire
     * @return NewsLock
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
     * @return NewsLock
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
