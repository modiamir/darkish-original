<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommentLike
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CommentLike
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
    private $userType;

    /**
     * @ORM\Column(name="user_id", type="integer")
     * 
     */
    private $userId;

    /**
     * @ORM\ManyToOne(targetEntity="\Darkish\CommentBundle\Entity\Comment")
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
     * Set userType
     *
     * @param string $userType
     * @return CommentLike
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;

        return $this;
    }

    /**
     * Get userType
     *
     * @return string 
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     * @return CommentLike
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

    /**
     * Set target
     *
     * @param \Darkish\CommentBundle\Entity\Comment $target
     * @return CommentLike
     */
    public function setTarget(\Darkish\CommentBundle\Entity\Comment $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return \Darkish\CommentBundle\Entity\Comment 
     */
    public function getTarget()
    {
        return $this->target;
    }
}
