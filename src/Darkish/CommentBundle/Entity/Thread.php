<?php

namespace Darkish\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\CommentBundle\Entity\Thread as BaseThread;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="thread_type", type="string")
 * @ORM\DiscriminatorMap({"record" = "RecordThread", "news" = "NewsThread", "forum_tree": "ForumTreeThread", "safarsaz": "SafarsazThread" ,"thread" = "Thread"})
 */
class Thread
{
    /**
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="thread", cascade={"remove"})
     * @Groups("thread.details")
     */
    protected $comments;

    /**
     * @ORM\Column(name="last_comment_at", type="datetime")
     * @Groups("thread.details")
     */
    protected $lastCommentAt;

    /**
     * @ORM\Column(name="num_comments", type="integer", options={"default"=0})
     * @Groups("thread.details")
     */
    protected $numComments = 0;

    /**
     * @ORM\Column(name="is_commentable", type="boolean", options={"default"=true})
     * @Groups("thread.details")
     */
    protected $isCommentable;


    
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
     * @return Thread
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
     * @return Thread
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
     * Add comments
     *
     * @param \Darkish\CommentBundle\Entity\Comment $comments
     * @return Thread
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
     * Set lastCommentAt
     *
     * @param \DateTime $lastCommentAt
     * @return Thread
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
