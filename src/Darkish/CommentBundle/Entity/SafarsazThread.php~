<?php

namespace Darkish\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Darkish\CommentBundle\Entity\Thread;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;

/**
 * PostComment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SafarsazThread extends Thread
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
     * @ORM\OneToOne(targetEntity="\Darkish\CategoryBundle\Entity\Safarsaz", inversedBy="thread")
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
     * @param \Darkish\CategoryBundle\Entity\Safarsaz $target
     * @return SafarsazThread
     */
    public function setTarget(\Darkish\CategoryBundle\Entity\Safarsaz $target = null)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * Get target
     *
     * @return \Darkish\CategoryBundle\Entity\Safarsaz 
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set test
     *
     * @param string $test
     * @return SafarsazThread
     */
    public function setTest($test)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return string 
     */
    public function getTest()
    {
        return $this->test;
    }
}
