<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Safarsaz
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Safarsaz
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity="\Darkish\CommentBundle\Entity\SafarsazThread", mappedBy="target")
     * 
     */
    private $thread;


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
     * Set name
     *
     * @param string $name
     * @return Safarsaz
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set thread
     *
     * @param \Darkish\CommentBundle\Entity\SafarsazThread $thread
     * @return Safarsaz
     */
    public function setThread(\Darkish\CommentBundle\Entity\SafarsazThread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Darkish\CommentBundle\Entity\SafarsazThread 
     */
    public function getThread()
    {
        return $this->thread;
    }
}
