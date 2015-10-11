<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * SafarsazType
 *
 * @ORM\Table(name="safarsaztype")
 * @ORM\Entity
 */
class SafarsazType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Groups({"record.details", "safarsaz.list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"record.details", "safarsaz.list"})
     *
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="Record", mappedBy="safarsazTypeIndex")
     *
     * @Groups({"record.details"})
     */
    protected $records;


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
     * @return SafarsazType
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
     * Constructor
     */
    public function __construct()
    {
        $this->records = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add records
     *
     * @param \Darkish\CategoryBundle\Entity\Record $records
     * @return SafarsazType
     */
    public function addRecord(\Darkish\CategoryBundle\Entity\Record $records)
    {
        $this->records[] = $records;
    
        return $this;
    }

    /**
     * Remove records
     *
     * @param \Darkish\CategoryBundle\Entity\Record $records
     */
    public function removeRecord(\Darkish\CategoryBundle\Entity\Record $records)
    {
        $this->records->removeElement($records);
    }

    /**
     * Get records
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecords()
    {
        return $this->records;
    }
}
