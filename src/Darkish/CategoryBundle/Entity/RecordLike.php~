<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RecordLike
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RecordLike
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
     * @ORM\Column(name="user_type", type="string")
     * 
     */
    private $user_type;

    /**
     * @ORM\Column(name="user_id", type="integer")
     * 
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity="Record")
     */
    private $target;


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
     * Set user_type
     *
     * @param string $userType
     * @return RecordLike
     */
    public function setUserType($userType)
    {
        $this->user_type = $userType;

        return $this;
    }

    /**
     * Get user_type
     *
     * @return string 
     */
    public function getUserType()
    {
        return $this->user_type;
    }

    /**
     * Set user_id
     *
     * @param integer $userId
     * @return RecordLike
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get user_id
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set target
     *
     * @param \Darkish\CategoryBundle\Entity\Record $target
     * @return RecordLike
     */
    public function setTarget(\Darkish\CategoryBundle\Entity\Record $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return \Darkish\CategoryBundle\Entity\Record 
     */
    public function getTarget()
    {
        return $this->target;
    }
}
