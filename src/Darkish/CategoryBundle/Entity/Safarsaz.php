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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_title", type="string", length=255)
     */
    private $subTitle;

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

    /**
     * Set title
     *
     * @param string $title
     * @return Safarsaz
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set subTitle
     *
     * @param string $subTitle
     * @return Safarsaz
     */
    public function setSubTitle($subTitle)
    {
        $this->subTitle = $subTitle;

        return $this;
    }

    /**
     * Get subTitle
     *
     * @return string 
     */
    public function getSubTitle()
    {
        return $this->subTitle;
    }
}
