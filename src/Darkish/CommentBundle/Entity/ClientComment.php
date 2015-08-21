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
class ClientComment extends Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"comment.details", "api.list"})
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Darkish\UserBundle\Entity\Client", inversedBy="comments")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * @Groups({"comment.details", "api.list"})
     */
    protected $owner;

    
    /**
     * @var integer
     * @Groups({"comment.details", "api.list"})
     */
    protected $likeCount;

    /**
     * @var integer
     * @Groups({"comment.details"})
     */
    protected $claimType;

    /**
     * @var integer
     * @Groups({"comment.details", "api.list"})
     */
    protected $replyCount = 0;

    /**
     * @var string
     * @Groups({"comment.details", "api.list"})
     */
    protected $body;

    /**
     * @var \DateTime
     * @Groups({"comment.details", "api.list"})
     */
    protected $createdAt;

    /**
     * @var string
     * @Groups({"comment.details", "api.list"})
     */
    protected $ownerType;

    /**
     * @var integer
     * @Groups({"comment.details"})
     */
    protected $state;

    /**
     * @var \Darkish\CommentBundle\Entity\Thread
     * @Groups({"comment.details"})
     */
    protected $thread;

    /**
     * @var \Darkish\CommentBundle\Entity\Comment
     * @Groups({"comment.details", "api.list"})
     */
    protected $parent;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $children;

    /**
     * @var boolean
     * @Groups({"comment.details", "api.list"})
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
     * Set ownerType
     *
     * @param string $ownerType
     * @return Comment
     */
    public function setOwnerType($ownerType)
    {
        $this->ownerType = $ownerType;

        return $this;
    }

    /**
     * Get ownerType
     *
     * @return string
     */
    public function getOwnerType()
    {
        return $this->ownerType;
    }

    /**
     * Set likeCount
     *
     * @param integer $likeCount
     * @return CustomerComment
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
     * @return CustomerComment
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
     * @return CustomerComment
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
     * @return CustomerComment
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
     * @return CustomerComment
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
     * @return CustomerComment
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
     * @param \Darkish\UserBundle\Entity\Client $owner
     * @return CustomerComment
     */
    public function setOwner(\Darkish\UserBundle\Entity\Client $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Darkish\UserBundle\Entity\Client 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set thread
     *
     * @param \Darkish\CommentBundle\Entity\Thread $thread
     * @return CustomerComment
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
     * @return CustomerComment
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
     * @return CustomerComment
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
    /**
     * @var boolean
     * @Groups({"comment.details"})
     */
    protected $unseenByOperators;

    /**
     * @var integer
     * @Groups({"comment.details"})
     */
    protected $unseenRepliesByOperators;

    /**
     * @var boolean
     * @Groups({"comment.details"})
     */
    protected $unseenByCustomers;

    /**
     * @var integer
     * @Groups({"comment.details"})
     */
    protected $unseenRepliesByCustomers;


    /**
     * Set unseenByOperators
     *
     * @param boolean $unseenByOperators
     * @return ClientComment
     */
    public function setUnseenByOperators($unseenByOperators)
    {
        $this->unseenByOperators = $unseenByOperators;

        return $this;
    }

    /**
     * Get unseenByOperators
     *
     * @return boolean 
     */
    public function getUnseenByOperators()
    {
        return $this->unseenByOperators;
    }

    /**
     * Set unseenRepliesByOperators
     *
     * @param integer $unseenRepliesByOperators
     * @return ClientComment
     */
    public function setUnseenRepliesByOperators($unseenRepliesByOperators)
    {
        $this->unseenRepliesByOperators = $unseenRepliesByOperators;

        return $this;
    }

    /**
     * Get unseenRepliesByOperators
     *
     * @return integer 
     */
    public function getUnseenRepliesByOperators()
    {
        return $this->unseenRepliesByOperators;
    }

    /**
     * Set unseenByCustomers
     *
     * @param boolean $unseenByCustomers
     * @return ClientComment
     */
    public function setUnseenByCustomers($unseenByCustomers)
    {
        $this->unseenByCustomers = $unseenByCustomers;

        return $this;
    }

    /**
     * Get unseenByCustomers
     *
     * @return boolean 
     */
    public function getUnseenByCustomers()
    {
        return $this->unseenByCustomers;
    }

    /**
     * Set unseenRepliesByCustomers
     *
     * @param integer $unseenRepliesByCustomers
     * @return ClientComment
     */
    public function setUnseenRepliesByCustomers($unseenRepliesByCustomers)
    {
        $this->unseenRepliesByCustomers = $unseenRepliesByCustomers;

        return $this;
    }

    /**
     * Get unseenRepliesByCustomers
     *
     * @return integer 
     */
    public function getUnseenRepliesByCustomers()
    {
        return $this->unseenRepliesByCustomers;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Groups({"comment.details", "api.list"})
     */
    protected $photos;


    /**
     * Add photos
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $photos
     * @return ClientComment
     */
    public function addPhoto(\Darkish\CategoryBundle\Entity\ManagedFile $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $photos
     */
    public function removePhoto(\Darkish\CategoryBundle\Entity\ManagedFile $photos)
    {
        $this->photos->removeElement($photos);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPhotos()
    {
        return $this->photos;
    }
}
