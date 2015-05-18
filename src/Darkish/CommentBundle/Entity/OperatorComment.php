<?php

namespace Darkish\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Darkish\CommentBundle\Entity\Comment;
use JMS\Serializer\Annotation\Groups;

/**
 * UserComment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class OperatorComment extends Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups("comment.details")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Darkish\UserBundle\Entity\Operator", inversedBy="comments")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * @Groups("comment.details")
     */
    protected $owner;

    
    /**
     * @var integer
     * @Groups("comment.details")
     */
    protected $likeCount;

    /**
     * @var integer
     * @Groups("comment.details")
     */
    protected $claimType;

    /**
     * @var integer
     * @Groups("comment.details")
     */
    protected $replyCount = 0;

    /**
     * @var string
     * @Groups("comment.details")
     */
    protected $body;

    /**
     * @var \DateTime
     * @Groups("comment.details")
     */
    protected $createdAt;

    /**
     * @var integer
     * @Groups("comment.details")
     */
    protected $state;

    /**
     * @var \Darkish\CommentBundle\Entity\Thread
     * @Groups("comment.details")
     */
    protected $thread;

    /**
     * @var \Darkish\CommentBundle\Entity\Comment
     * @Groups("comment.details")
     */
    protected $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $children;

    /**
     * @var boolean
     * @Groups("comment.details")
     */
    protected $hasLiked;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set likeCount
     *
     * @param integer $likeCount
     * @return OperatorComment
     */
    public function setLikeCount($likeCount)
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    /**
     * Get likeCount
     *
     * @return integer 
     */
    public function getLikeCount()
    {
        return $this->likeCount;
    }

    /**
     * Set claimType
     *
     * @param integer $claimType
     * @return OperatorComment
     */
    public function setClaimType($claimType)
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

    /**
     * Set replyCount
     *
     * @param integer $replyCount
     * @return OperatorComment
     */
    public function setReplyCount($replyCount)
    {
        $this->replyCount = $replyCount;

        return $this;
    }

    /**
     * Get replyCount
     *
     * @return integer 
     */
    public function getReplyCount()
    {
        return $this->replyCount;
    }

    /**
     * Set body
     *
     * @param string $body
     * @return OperatorComment
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return OperatorComment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return OperatorComment
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set owner
     *
     * @param \Darkish\UserBundle\Entity\Operator $owner
     * @return OperatorComment
     */
    public function setOwner(\Darkish\UserBundle\Entity\Operator $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Darkish\UserBundle\Entity\Operator 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set thread
     *
     * @param \Darkish\CommentBundle\Entity\Thread $thread
     * @return OperatorComment
     */
    public function setThread(\Darkish\CommentBundle\Entity\Thread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Darkish\CommentBundle\Entity\Thread 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set parent
     *
     * @param \Darkish\CommentBundle\Entity\Comment $parent
     * @return OperatorComment
     */
    public function setParent(\Darkish\CommentBundle\Entity\Comment $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Darkish\CommentBundle\Entity\Comment 
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param \Darkish\CommentBundle\Entity\Comment $children
     * @return OperatorComment
     */
    public function addChild(\Darkish\CommentBundle\Entity\Comment $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Darkish\CommentBundle\Entity\Comment $children
     */
    public function removeChild(\Darkish\CommentBundle\Entity\Comment $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set hasLiked
     *
     * @param boolean $hasLiked
     * @return OperatorComment
     */
    public function setHasLiked($hasLiked)
    {
        $this->hasLiked = $hasLiked;

        return $this;
    }

    /**
     * Get hasLiked
     *
     * @return boolean
     */
    public function getHasLiked()
    {
        return $this->hasLiked;
    }
}
