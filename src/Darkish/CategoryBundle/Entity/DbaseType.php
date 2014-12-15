<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * DbaseType
 *
 * @ORM\Table(name="dbasetype")
 * @ORM\Entity
 */
class DbaseType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"record.details", "dbase.list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Name", type="string", length=255)
     * @Groups({"record.details", "dbase.list"})
     */
    private $name;


    /**
     * @ORM\OneToMany(targetEntity="Record", mappedBy="dbaseTypeIndex")
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
     * @return DbaseType
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
     * @return DbaseType
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
