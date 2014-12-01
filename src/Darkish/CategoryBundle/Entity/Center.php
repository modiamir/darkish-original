<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Center
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Center
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"center.list", "record.details"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"center.list", "record.details"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_title", type="string", length=255, nullable=true)
     * @Groups({"center.list", "record.details"})
     * 
     */
    private $subTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="sort", type="string", length=255, nullable=true)
     */
    private $sort;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="CenterType", inversedBy="centers")
     * @ORM\JoinColumn(name="center_type_id", referencedColumnName="id")
     */
    private $centerType;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_of_floors", type="integer", nullable=true)
     */
    private $numOfFloors;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_of_units", type="integer", nullable=true)
     */
    private $numOfUnits;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255, nullable=true)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255, nullable=true)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="icon_index", type="string", length=255, nullable=true)
     */
    private $iconIndex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="show_brands", type="boolean", nullable=true)
     */
    private $showBrands;

    /**
     * @var boolean
     *
     * @ORM\Column(name="show_offers", type="boolean", nullable=true)
     */
    private $showOffers;

    /**
     * @var string
     *
     * @ORM\Column(name="record_id", type="string", length=255, nullable=true)
     */
    private $recordId;

    /**
     * @var string
     *
     * @ORM\Column(name="tree_index", type="string", length=255, nullable=true)
     */
    private $treeIndex;

    /**
     * @ORM\OneToMany(targetEntity="Record", mappedBy="center")
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
     * @return Center
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
     * Set subTitle
     *
     * @param string $subTitle
     * @return Center
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

    /**
     * Set sort
     *
     * @param string $sort
     * @return Center
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

    /**
     * Set centerType
     *
     * @param integer $centerType
     * @return Center
     */
    public function setCenterType($centerType)
    {
        $this->centerType = $centerType;
    
        return $this;
    }

    /**
     * Get centerType
     *
     * @return integer 
     */
    public function getCenterType()
    {
        return $this->centerType;
    }

    /**
     * Set numOfFloors
     *
     * @param integer $numOfFloors
     * @return Center
     */
    public function setNumOfFloors($numOfFloors)
    {
        $this->numOfFloors = $numOfFloors;
    
        return $this;
    }

    /**
     * Get numOfFloors
     *
     * @return integer 
     */
    public function getNumOfFloors()
    {
        return $this->numOfFloors;
    }

    /**
     * Set numOfUnits
     *
     * @param integer $numOfUnits
     * @return Center
     */
    public function setNumOfUnits($numOfUnits)
    {
        $this->numOfUnits = $numOfUnits;
    
        return $this;
    }

    /**
     * Get numOfUnits
     *
     * @return integer 
     */
    public function getNumOfUnits()
    {
        return $this->numOfUnits;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Center
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    
        return $this;
    }

    /**
     * Get longitude
     *
     * @return string 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     * @return Center
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    
        return $this;
    }

    /**
     * Get latitude
     *
     * @return string 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set iconIndex
     *
     * @param string $iconIndex
     * @return Center
     */
    public function setIconIndex($iconIndex)
    {
        $this->iconIndex = $iconIndex;
    
        return $this;
    }

    /**
     * Get iconIndex
     *
     * @return string 
     */
    public function getIconIndex()
    {
        return $this->iconIndex;
    }

    /**
     * Set showBrands
     *
     * @param boolean $showBrands
     * @return Center
     */
    public function setShowBrands($showBrands)
    {
        $this->showBrands = $showBrands;
    
        return $this;
    }

    /**
     * Get showBrands
     *
     * @return boolean 
     */
    public function getShowBrands()
    {
        return $this->showBrands;
    }

    /**
     * Set showOffers
     *
     * @param boolean $showOffers
     * @return Center
     */
    public function setShowOffers($showOffers)
    {
        $this->showOffers = $showOffers;
    
        return $this;
    }

    /**
     * Get showOffers
     *
     * @return boolean 
     */
    public function getShowOffers()
    {
        return $this->showOffers;
    }

    /**
     * Set recordId
     *
     * @param string $recordId
     * @return Center
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;
    
        return $this;
    }

    /**
     * Get recordId
     *
     * @return string 
     */
    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * Set treeIndex
     *
     * @param string $treeIndex
     * @return Center
     */
    public function setTreeIndex($treeIndex)
    {
        $this->treeIndex = $treeIndex;
    
        return $this;
    }

    /**
     * Get treeIndex
     *
     * @return string 
     */
    public function getTreeIndex()
    {
        return $this->treeIndex;
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
     * @return Center
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
