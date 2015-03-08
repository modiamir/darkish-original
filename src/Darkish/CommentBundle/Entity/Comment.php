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
 * @ORM\DiscriminatorMap({"operator" = "OperatorComment", "customer" = "CustomerComment", "comment"="Comment"})
 */
class Comment extends BaseComment
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
    private $likeCount;

    /**
     * @ORM\Column(name="claim_type", type="integer", nullable=true)
     * @Groups("comment.details")
     */
    private $claimType;

    /**
     * Thread of this comment
     *
     * @var Thread
     * @ORM\ManyToOne(targetEntity="Thread", inversedBy="comments")
     * @Groups("comment.details")
     */
    protected $thread;

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
     * Set thread
     *
     * @param \Darkish\CommentBundle\Entity\Thread $thread
     * @return Comment
     */
    public function setThread(\FOS\CommentBundle\Model\ThreadInterface $thread = null)
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
}
