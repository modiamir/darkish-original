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
    private $owner;

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
     * @var \Darkish\CommentBundle\Entity\Thread
     */
    protected $thread;


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
}
