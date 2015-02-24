<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * ClassifiedLock
 *
 * @ORM\Table(name="classified_lock")
 * @ORM\Entity
 */
class ClassifiedLock
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
     * @ORM\Column(name="classified_number", type="string", length=255, nullable=false)
     * 
     */
    private $classifiedNumber;

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
     * @return ClassifiedLock
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
     * Set classifiedNumber
     *
     * @param string $classifiedNumber
     * @return ClassifiedLock
     */
    public function setClassifiedNumber($classifiedNumber)
    {
        $this->classifiedNumber = $classifiedNumber;

        return $this;
    }

    /**
     * Get classifiedNumber
     *
     * @return string 
     */
    public function getClassifiedNumber()
    {
        return $this->classifiedNumber;
    }

    /**
     * Set expire
     *
     * @param \DateTime $expire
     * @return ClassifiedLock
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
     * @return ClassifiedLock
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
