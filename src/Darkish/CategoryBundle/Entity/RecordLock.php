<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * RecordLock
 *
 * @ORM\Table(name="record_lock")
 * @ORM\Entity
 */
class RecordLock
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
     * @ORM\Column(name="record_number", type="string", length=255, nullable=false)
     * 
     */
    private $recordNumber;

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
     * @return RecordLock
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
     * Set recordNumber
     *
     * @param string $recordNumber
     * @return RecordLock
     */
    public function setRecordNumber($recordNumber)
    {
        $this->recordNumber = $recordNumber;

        return $this;
    }

    /**
     * Get recordNumber
     *
     * @return string 
     */
    public function getRecordNumber()
    {
        return $this->recordNumber;
    }

    /**
     * Set expire
     *
     * @param \DateTime $expire
     * @return RecordLock
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
     * @return RecordLock
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
