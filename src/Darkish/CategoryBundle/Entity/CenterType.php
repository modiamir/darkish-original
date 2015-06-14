<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CenterType
 *
 * @ORM\Table(name="centertype")
 * @ORM\Entity
 */
class CenterType
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
     * @ORM\OneToMany(targetEntity="Center", mappedBy="centerType")
     */
    protected $centers;


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
     * @return CenterType
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    public function __toString()
    {
        return ($this->getName()) ? : '';
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
     * Constructor
     */
    public function __construct()
    {
        $this->centers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add centers
     *
     * @param \Darkish\CategoryBundle\Entity\Center $centers
     * @return CenterType
     */
    public function addCenter(\Darkish\CategoryBundle\Entity\Center $centers)
    {
        $this->centers[] = $centers;
    
        return $this;
    }

    /**
     * Remove centers
     *
     * @param \Darkish\CategoryBundle\Entity\Center $centers
     */
    public function removeCenter(\Darkish\CategoryBundle\Entity\Center $centers)
    {
        $this->centers->removeElement($centers);
    }

    /**
     * Get centers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCenters()
    {
        return $this->centers;
    }
}
