<?php

namespace Darkish\CategoryBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * RecordMainTree
 *
 * @ORM\Table(name="record_trees")
 * @ORM\Entity
 */
class RecordMainTree
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Record",  inversedBy="maintrees")
     * @ORM\JoinColumn(name="record_id", referencedColumnName="id")
     * @Groups({ "maintree.list", "maintree.details"})
     **/
    private $record;
    
    /**
     * @ORM\ManyToOne(targetEntity="MainTree",  inversedBy="mainrecords")
     * @ORM\JoinColumn(name="tree_id", referencedColumnName="id")
     * @Groups({"maintree.list", "maintree.details", "record.list", "record.details", "api.list"})
     **/
    private $tree;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="sort", type="string", nullable=true) 
     * @Groups({"maintree.list", "maintree.details", "record.list", "record.details", "api.list"})
     */
    private $sort;

    /**
     * Set record
     *
     * @param \Darkish\CategoryBundle\Entity\Record $record
     * @return RecordMainTree
     */
    public function setRecord(\Darkish\CategoryBundle\Entity\Record $record = null)
    {
        $this->record = $record;

        return $this;
    }

    /**
     * Get record
     *
     * @return \Darkish\CategoryBundle\Entity\Record 
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * Set tree
     *
     * @param \Darkish\CategoryBundle\Entity\MainTree $tree
     * @return RecordMainTree
     */
    public function setTree(\Darkish\CategoryBundle\Entity\MainTree $tree = null)
    {
        $this->tree = $tree;

        return $this;
    }

    /**
     * Get tree
     *
     * @return \Darkish\CategoryBundle\Entity\MainTree 
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * Set sort
     *
     * @param string $sort
     * @return RecordMainTree
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return string 
     */
    public function getSort()
    {
        return $this->sort;
    }
}
