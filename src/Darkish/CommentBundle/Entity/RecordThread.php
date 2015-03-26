<?php

namespace Darkish\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Darkish\CommentBundle\Entity\Thread;

/**
 * PostComment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RecordThread extends Thread
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
     * @ORM\OneToOne(targetEntity="\Darkish\CategoryBundle\Entity\Record", inversedBy="thread")
     * @ORM\JoinColumn(name="target_id", referencedColumnName="id")
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
     * Set target
     *
     * @param \Darkish\CategoryBundle\Entity\Record $target
     * @return RecordThread
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
