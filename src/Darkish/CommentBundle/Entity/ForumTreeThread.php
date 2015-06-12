<?php

namespace Darkish\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Darkish\CommentBundle\Entity\Thread;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;


/**
 * PostComment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ForumTreeThread extends Thread
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToOne(targetEntity="\Darkish\CategoryBundle\Entity\ForumTree", inversedBy="thread")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id")
     * @Groups({"comment.details", "api.list"})
     */
    protected $target;


    


    /**
     * @var integer
     */
    protected $numComments;

    /**
     * @var boolean
     */
    protected $isCommentable;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $comments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set numComments
     *
     * @param integer $numComments
     * @return ForumTreeThread
     */
    public function setNumComments($numComments)
    {
        $this->numComments = $numComments;

        return $this;
    }

    /**
     * Get numComments
     *
     * @return integer 
     */
    public function getNumComments()
    {
        return $this->numComments;
    }

    /**
     * Set isCommentable
     *
     * @param boolean $isCommentable
     * @return ForumTreeThread
     */
    public function setIsCommentable($isCommentable)
    {
        $this->isCommentable = $isCommentable;

        return $this;
    }

    /**
     * Get isCommentable
     *
     * @return boolean 
     */
    public function getIsCommentable()
    {
        return $this->isCommentable;
    }

    /**
     * Set target
     *
     * @param \Darkish\CategoryBundle\Entity\ForumTree $target
     * @return ForumTreeThread
     */
    public function setTarget(\Darkish\CategoryBundle\Entity\ForumTree $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return \Darkish\CategoryBundle\Entity\ForumTree 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Add comments
     *
     * @param \Darkish\CommentBundle\Entity\Comment $comments
     * @return ForumTreeThread
     */
    public function addComment(\Darkish\CommentBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Darkish\CommentBundle\Entity\Comment $comments
     */
    public function removeComment(\Darkish\CommentBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }
    /**
     * @var \DateTime
     */
    protected $lastCommentAt;


    /**
     * Set lastCommentAt
     *
     * @param \DateTime $lastCommentAt
     * @return ForumTreeThread
     */
    public function setLastCommentAt($lastCommentAt)
    {
        $this->lastCommentAt = $lastCommentAt;

        return $this;
    }

    /**
     * Get lastCommentAt
     *
     * @return \DateTime 
     */
    public function getLastCommentAt()
    {
        return $this->lastCommentAt;
    }
}
