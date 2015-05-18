<?php
// src/MyProject/MyBundle/Entity/Comment.php

namespace Darkish\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Comment as BaseComment;
use JMS\Serializer\Annotation\Groups;


/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="owner_type", type="string")
 * @ORM\DiscriminatorMap({"operator" = "OperatorComment", "customer" = "CustomerComment", "client" = "ClientComment", "comment"="Comment"})
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups("comment.details")
     */
    protected $id;

    /**
     * @ORM\Column(name="like_count", type="integer", nullable=true)
     * @Groups("comment.details")
     */
    protected $likeCount;

    /**
     * @ORM\Column(name="claim_type", type="integer", nullable=true)
     * @Groups("comment.details")
     */
    protected $claimType;

    /**
     * @ORM\Column(name="reply_count", type="integer", options={"unsigned":true, "default":0})
     * @Groups("comment.details")
     */
    protected $replyCount = 0;

    /**
     * Thread of this comment
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="Thread", inversedBy="comments")
     * @Groups("comment.details")
     */
    protected $thread;

    /**
     * @ORM\Column(name="body", type="text")
     * @Groups("comment.details")
     */
    protected $body;

    /**
     * @ORM\ManyToOne(targetEntity="Comment", inversedBy="children")
     * @Groups("comment.details")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="parent")
     * 
     */
    protected $children;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     * @Groups("comment.details")
     */
    protected $createdAt;


    /**
     * @ORM\Column(name="state", type="smallint")
     * @Groups("comment.details")
     */
    protected $state;

    /**
     * @var boolean
     * @Groups("comment.details")
     */
    protected $hasLiked;

    protected $unseenByOperators;

    protected $unseenRepliesByOperators;

    protected $unseenByCustomers;

    protected $unseenRepliesByCustomers;

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
     * @return Comment
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
     * @return Comment
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
     * @return Comment
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
     * @return Comment
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
     * @return Comment
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
     * @return Comment
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
     * Set thread
     *
     * @param \Darkish\CommentBundle\Entity\Thread $thread
     * @return Comment
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
     * @return Comment
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
     * @return Comment
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
