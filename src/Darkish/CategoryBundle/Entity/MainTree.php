<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;


/**
 * MainTree
 *
 * @ORM\Table(name="maintree")
 * @ORM\Entity(repositoryClass="Darkish\CategoryBundle\Entity\MainTreeRepository")
 */
class MainTree
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"list", "details", "record.details", "api.list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="UpTreeIndex", type="string", length=255)
     * @Groups({"list", "details", "record.details"})
     */
    private $upTreeIndex;
    
    /**
     *
     * @Groups({"list", "details", "record.details"})
     */
    private $parentTreeTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="TreeIndex", type="string", length=255)
     * @Groups({"list", "details", "record.details", "api.list"})
     */
    private $treeIndex;

    /**
     * @var integer
     *
     * @ORM\Column(name="Sort", type="integer")
     * @Groups({"list"})
     */
    private $sort;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=255)
     * @Groups({"list", "details", "record.details", "api.list"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="SubTitle", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $subTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="BackKeyTitle", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $backKeyTitle;


    /**
     * @var string
     *
     * @ORM\Column(name="SearchKeywords", type="text", nullable=true)
     */
    private $searchKeywords;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowInfoKey", type="boolean", nullable=true)
     */
    private $showInfoKey;

    /**
     * @var string
     *
     * @ORM\Column(name="InfoKeyTitle", type="string", length=255, nullable=true)
     */
    private $infoKeyTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="InfoHtmlIndex", type="string", length=255, nullable=true)
     */
    private $infoHtmlIndex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowSubtreeAsFilter", type="boolean", nullable=true)
     */
    private $showSubtreeAsFilter;

    /**
     * @var string
     *
     * @ORM\Column(name="ShowDistanceFilter", type="string", length=255, nullable=true)
     */
    private $showDistanceFilter;

    /**
     * @var boolean
     *
     * @ORM\Column(name="DistanceFilterWithArea", type="boolean", nullable=true)
     */
    private $distanceFilterWithArea;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowBrandsKey", type="boolean", nullable=true)
     */
    private $showBrandsKey;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowMessagesKey", type="boolean", nullable=true)
     */
    private $showMessagesKey;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowSponsorBox", type="boolean", nullable=true)
     */
    private $showSponsorBox;

    /**
     * @var integer
     *
     * @ORM\Column(name="SponsorGroup", type="integer", nullable=true)
     */
    private $sponsorGroup;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowCenters", type="boolean", nullable=true)
     */
    private $showCenters;

    /**
     * @var string
     *
     * @ORM\Column(name="CentersKeyTitle", type="string", length=255, nullable=true)
     */
    private $centersKeyTitle;

    /**
     * @var integer
     *
     * @ORM\Column(name="CentersGroupIndex", type="integer", nullable=true)
     */
    private $centersGroupIndex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="CentersShowAsDefault", type="boolean", nullable=true)
     */
    private $centersShowAsDefault;

    /**
     * @var boolean
     *
     * @ORM\Column(name="CentersListAfterGroup", type="boolean", nullable=true)
     */
    private $centersListAfterGroup;

    /**
     * @var integer
     *
     * @ORM\Column(name="DbaseType", type="integer", nullable=true)
     */
    private $dbaseType;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowDbaseKey", type="boolean", nullable=true)
     */
    private $showDbaseKey;

    /**
     * @var string
     *
     * @ORM\Column(name="DbaseKeyTitle", type="string", length=255, nullable=true)
     */
    private $dbaseKeyTitle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowDbaseUpdate", type="boolean", nullable=true)
     */
    private $showDbaseUpdate;

    /**
     * @var string
     *
     * @ORM\Column(name="DbaseUpdateKeyTitle", type="string", length=255, nullable=true)
     */
    private $dbaseUpdateKeyTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="IconFileName", type="string", length=255, nullable=true)
     */
    private $iconFileName;

    /**
     * @var string
     *
     * @ORM\Column(name="IconSetFilesName", type="string", length=255, nullable=true)
     */
    private $iconSetFilesName;

    /**
     * @var string
     *
     * @ORM\Column(name="FontColor", type="string", length=255, nullable=true)
     */
    private $fontColor;

    /**
     * @var string
     *
     * @ORM\Column(name="BackColor", type="string", length=255, nullable=true)
     */
    private $backColor;

    /**
     * @var boolean
     *
     * @ORM\Column(name="SubPicShow", type="boolean", nullable=true)
     */
    private $subPicShow;

    /**
     * @var string
     *
     * @ORM\Column(name="SubBackground", type="string", length=255, nullable=true)
     */
    private $subBackground;

    /**
     * @var string
     *
     * @ORM\Column(name="GroupFilter", type="boolean", length=255, nullable=true)
     */
    private $groupFilter;

    /**
     * @var boolean
     *
     * @ORM\Column(name="HiddenTree", type="boolean", nullable=true)
     */
    private $hiddenTree;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $records
     *
     * @ORM\ManyToMany(targetEntity="Darkish\CategoryBundle\Entity\Record", mappedBy="trees")
     */
    protected $records;
    
    /**
     * @ORM\OneToMany(targetEntity="RecordMainTree", mappedBy="tree")
     **/
    private $mainrecords;

    /**
     * @ORM\Column(name="recommend_ids", type="json_array", nullable=true)
     * @Groups({"list", "details", "record.details", "api.list"})
     */
    private $recommendIds;

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
     * Set upTreeIndex
     *
     * @param string $upTreeIndex
     * @return MainTree
     */
    public function setUpTreeIndex($upTreeIndex)
    {
        $this->upTreeIndex = $upTreeIndex;

        return $this;
    }

    /**
     * Get upTreeIndex
     *
     * @return string 
     */
    public function getUpTreeIndex()
    {
        return $this->upTreeIndex;
    }

    /**
     * Set treeIndex
     *
     * @param string $treeIndex
     * @return MainTree
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
     * Set sort
     *
     * @param integer $sort
     * @return MainTree
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return MainTree
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
     * @return MainTree
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
     * Set backKeyTitle
     *
     * @param string $backKeyTitle
     * @return MainTree
     */
    public function setBackKeyTitle($backKeyTitle)
    {
        $this->backKeyTitle = $backKeyTitle;

        return $this;
    }

    /**
     * Get backKeyTitle
     *
     * @return string 
     */
    public function getBackKeyTitle()
    {
        return $this->backKeyTitle;
    }

    /**
     * Set searchKeywords
     *
     * @param string $searchKeywords
     * @return MainTree
     */
    public function setSearchKeywords($searchKeywords)
    {
        $this->searchKeywords = $searchKeywords;

        return $this;
    }

    /**
     * Get searchKeywords
     *
     * @return string 
     */
    public function getSearchKeywords()
    {
        return $this->searchKeywords;
    }

    /**
     * Set showInfoKey
     *
     * @param boolean $showInfoKey
     * @return MainTree
     */
    public function setShowInfoKey($showInfoKey)
    {
        $this->showInfoKey = $showInfoKey;

        return $this;
    }

    /**
     * Get showInfoKey
     *
     * @return boolean 
     */
    public function getShowInfoKey()
    {
        return $this->showInfoKey;
    }

    /**
     * Set infoKeyTitle
     *
     * @param string $infoKeyTitle
     * @return MainTree
     */
    public function setInfoKeyTitle($infoKeyTitle)
    {
        $this->infoKeyTitle = $infoKeyTitle;

        return $this;
    }

    /**
     * Get infoKeyTitle
     *
     * @return string 
     */
    public function getInfoKeyTitle()
    {
        return $this->infoKeyTitle;
    }

    /**
     * Set infoHtmlIndex
     *
     * @param string $infoHtmlIndex
     * @return MainTree
     */
    public function setInfoHtmlIndex($infoHtmlIndex)
    {
        $this->infoHtmlIndex = $infoHtmlIndex;

        return $this;
    }

    /**
     * Get infoHtmlIndex
     *
     * @return string 
     */
    public function getInfoHtmlIndex()
    {
        return $this->infoHtmlIndex;
    }

    /**
     * Set showSubtreeAsFilter
     *
     * @param boolean $showSubtreeAsFilter
     * @return MainTree
     */
    public function setShowSubtreeAsFilter($showSubtreeAsFilter)
    {
        $this->showSubtreeAsFilter = $showSubtreeAsFilter;

        return $this;
    }

    /**
     * Get showSubtreeAsFilter
     *
     * @return boolean 
     */
    public function getShowSubtreeAsFilter()
    {
        return $this->showSubtreeAsFilter;
    }

    /**
     * Set showDistanceFilter
     *
     * @param string $showDistanceFilter
     * @return MainTree
     */
    public function setShowDistanceFilter($showDistanceFilter)
    {
        $this->showDistanceFilter = $showDistanceFilter;

        return $this;
    }

    /**
     * Get showDistanceFilter
     *
     * @return string 
     */
    public function getShowDistanceFilter()
    {
        return $this->showDistanceFilter;
    }

    /**
     * Set distanceFilterWithArea
     *
     * @param boolean $distanceFilterWithArea
     * @return MainTree
     */
    public function setDistanceFilterWithArea($distanceFilterWithArea)
    {
        $this->distanceFilterWithArea = $distanceFilterWithArea;

        return $this;
    }

    /**
     * Get distanceFilterWithArea
     *
     * @return boolean 
     */
    public function getDistanceFilterWithArea()
    {
        return $this->distanceFilterWithArea;
    }

    /**
     * Set showBrandsKey
     *
     * @param boolean $showBrandsKey
     * @return MainTree
     */
    public function setShowBrandsKey($showBrandsKey)
    {
        $this->showBrandsKey = $showBrandsKey;

        return $this;
    }

    /**
     * Get showBrandsKey
     *
     * @return boolean 
     */
    public function getShowBrandsKey()
    {
        return $this->showBrandsKey;
    }

    /**
     * Set showMessagesKey
     *
     * @param boolean $showMessagesKey
     * @return MainTree
     */
    public function setShowMessagesKey($showMessagesKey)
    {
        $this->showMessagesKey = $showMessagesKey;

        return $this;
    }

    /**
     * Get showMessagesKey
     *
     * @return boolean 
     */
    public function getShowMessagesKey()
    {
        return $this->showMessagesKey;
    }

    /**
     * Set showSponsorBox
     *
     * @param boolean $showSponsorBox
     * @return MainTree
     */
    public function setShowSponsorBox($showSponsorBox)
    {
        $this->showSponsorBox = $showSponsorBox;

        return $this;
    }

    /**
     * Get showSponsorBox
     *
     * @return boolean 
     */
    public function getShowSponsorBox()
    {
        return $this->showSponsorBox;
    }

    /**
     * Set sponsorGroup
     *
     * @param integer $sponsorGroup
     * @return MainTree
     */
    public function setSponsorGroup($sponsorGroup)
    {
        $this->sponsorGroup = $sponsorGroup;

        return $this;
    }

    /**
     * Get sponsorGroup
     *
     * @return integer 
     */
    public function getSponsorGroup()
    {
        return $this->sponsorGroup;
    }

    /**
     * Set showCenters
     *
     * @param boolean $showCenters
     * @return MainTree
     */
    public function setShowCenters($showCenters)
    {
        $this->showCenters = $showCenters;

        return $this;
    }

    /**
     * Get showCenters
     *
     * @return boolean 
     */
    public function getShowCenters()
    {
        return $this->showCenters;
    }

    /**
     * Set centersKeyTitle
     *
     * @param string $centersKeyTitle
     * @return MainTree
     */
    public function setCentersKeyTitle($centersKeyTitle)
    {
        $this->centersKeyTitle = $centersKeyTitle;

        return $this;
    }

    /**
     * Get centersKeyTitle
     *
     * @return string 
     */
    public function getCentersKeyTitle()
    {
        return $this->centersKeyTitle;
    }

    /**
     * Set centersGroupIndex
     *
     * @param integer $centersGroupIndex
     * @return MainTree
     */
    public function setCentersGroupIndex($centersGroupIndex)
    {
        $this->centersGroupIndex = $centersGroupIndex;

        return $this;
    }

    /**
     * Get centersGroupIndex
     *
     * @return integer 
     */
    public function getCentersGroupIndex()
    {
        return $this->centersGroupIndex;
    }

    /**
     * Set centersShowAsDefault
     *
     * @param boolean $centersShowAsDefault
     * @return MainTree
     */
    public function setCentersShowAsDefault($centersShowAsDefault)
    {
        $this->centersShowAsDefault = $centersShowAsDefault;

        return $this;
    }

    /**
     * Get centersShowAsDefault
     *
     * @return boolean 
     */
    public function getCentersShowAsDefault()
    {
        return $this->centersShowAsDefault;
    }

    /**
     * Set centersListAfterGroup
     *
     * @param boolean $centersListAfterGroup
     * @return MainTree
     */
    public function setCentersListAfterGroup($centersListAfterGroup)
    {
        $this->centersListAfterGroup = $centersListAfterGroup;

        return $this;
    }

    /**
     * Get centersListAfterGroup
     *
     * @return boolean 
     */
    public function getCentersListAfterGroup()
    {
        return $this->centersListAfterGroup;
    }

    /**
     * Set dbaseType
     *
     * @param integer $dbaseType
     * @return MainTree
     */
    public function setDbaseType($dbaseType)
    {
        $this->dbaseType = $dbaseType;

        return $this;
    }

    /**
     * Get dbaseType
     *
     * @return integer 
     */
    public function getDbaseType()
    {
        return $this->dbaseType;
    }

    /**
     * Set showDbaseKey
     *
     * @param boolean $showDbaseKey
     * @return MainTree
     */
    public function setShowDbaseKey($showDbaseKey)
    {
        $this->showDbaseKey = $showDbaseKey;

        return $this;
    }

    /**
     * Get showDbaseKey
     *
     * @return boolean 
     */
    public function getShowDbaseKey()
    {
        return $this->showDbaseKey;
    }

    /**
     * Set dbaseKeyTitle
     *
     * @param string $dbaseKeyTitle
     * @return MainTree
     */
    public function setDbaseKeyTitle($dbaseKeyTitle)
    {
        $this->dbaseKeyTitle = $dbaseKeyTitle;

        return $this;
    }

    /**
     * Get dbaseKeyTitle
     *
     * @return string 
     */
    public function getDbaseKeyTitle()
    {
        return $this->dbaseKeyTitle;
    }

    /**
     * Set showDbaseUpdate
     *
     * @param boolean $showDbaseUpdate
     * @return MainTree
     */
    public function setShowDbaseUpdate($showDbaseUpdate)
    {
        $this->showDbaseUpdate = $showDbaseUpdate;

        return $this;
    }

    /**
     * Get showDbaseUpdate
     *
     * @return boolean 
     */
    public function getShowDbaseUpdate()
    {
        return $this->showDbaseUpdate;
    }

    /**
     * Set dbaseUpdateKeyTitle
     *
     * @param string $dbaseUpdateKeyTitle
     * @return MainTree
     */
    public function setDbaseUpdateKeyTitle($dbaseUpdateKeyTitle)
    {
        $this->dbaseUpdateKeyTitle = $dbaseUpdateKeyTitle;

        return $this;
    }

    /**
     * Get dbaseUpdateKeyTitle
     *
     * @return string 
     */
    public function getDbaseUpdateKeyTitle()
    {
        return $this->dbaseUpdateKeyTitle;
    }

    /**
     * Set iconFileName
     *
     * @param string $iconFileName
     * @return MainTree
     */
    public function setIconFileName($iconFileName)
    {
        $this->iconFileName = $iconFileName;

        return $this;
    }

    /**
     * Get iconFileName
     *
     * @return string 
     */
    public function getIconFileName()
    {
        return $this->iconFileName;
    }

    /**
     * Set iconSetFilesName
     *
     * @param string $iconSetFilesName
     * @return MainTree
     */
    public function setIconSetFilesName($iconSetFilesName)
    {
        $this->iconSetFilesName = $iconSetFilesName;

        return $this;
    }

    /**
     * Get iconSetFilesName
     *
     * @return string 
     */
    public function getIconSetFilesName()
    {
        return $this->iconSetFilesName;
    }

    /**
     * Set fontColor
     *
     * @param string $fontColor
     * @return MainTree
     */
    public function setFontColor($fontColor)
    {
        $this->fontColor = $fontColor;

        return $this;
    }

    /**
     * Get fontColor
     *
     * @return string 
     */
    public function getFontColor()
    {
        return $this->fontColor;
    }

    /**
     * Set backColor
     *
     * @param string $backColor
     * @return MainTree
     */
    public function setBackColor($backColor)
    {
        $this->backColor = $backColor;

        return $this;
    }

    /**
     * Get backColor
     *
     * @return string 
     */
    public function getBackColor()
    {
        return $this->backColor;
    }

    /**
     * Set subPicShow
     *
     * @param boolean $subPicShow
     * @return MainTree
     */
    public function setSubPicShow($subPicShow)
    {
        $this->subPicShow = $subPicShow;

        return $this;
    }

    /**
     * Get subPicShow
     *
     * @return boolean 
     */
    public function getSubPicShow()
    {
        return $this->subPicShow;
    }

    /**
     * Set subBackground
     *
     * @param string $subBackground
     * @return MainTree
     */
    public function setSubBackground($subBackground)
    {
        $this->subBackground = $subBackground;

        return $this;
    }

    /**
     * Get subBackground
     *
     * @return string 
     */
    public function getSubBackground()
    {
        return $this->subBackground;
    }

    

    /**
     * Set hiddenTree
     *
     * @param boolean $hiddenTree
     * @return MainTree
     */
    public function setHiddenTree($hiddenTree)
    {
        $this->hiddenTree = $hiddenTree;

        return $this;
    }

    /**
     * Get hiddenTree
     *
     * @return boolean 
     */
    public function getHiddenTree()
    {
        return $this->hiddenTree;
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
     * @return MainTree
     */
    public function addRecord(\Darkish\CategoryBundle\Entity\Record $record)
    {
        $this->records[] = $record;

        return $this;
    }

    /**
     * Remove record
     *
     * @param \Darkish\CategoryBundle\Entity\Record $record
     */
    public function removeRecord(\Darkish\CategoryBundle\Entity\Record $record)
    {
        $this->records->removeElement($record);
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
    
    public function setParentTreeTitle($title) {
        $this->parentTreeTitle = $title;
        
        return $this;
    }
    
    /**
     * 
     * @return type
     * @VirtualProperty
     * @SerializedName("absolute_path")
     * @Groups({"list", "details", "record.details"})
     */
    public function getParentTreeTitle() {
        return $this->parentTreeTitle;
    }

    /**
     * Add mainrecords
     *
     * @param \Darkish\CategoryBundle\Entity\RecordMainTree $mainrecords
     * @return MainTree
     */
    public function addMainrecord(\Darkish\CategoryBundle\Entity\RecordMainTree $mainrecords)
    {
        $this->mainrecords[] = $mainrecords;

        return $this;
    }

    /**
     * Remove mainrecords
     *
     * @param \Darkish\CategoryBundle\Entity\RecordMainTree $mainrecords
     */
    public function removeMainrecord(\Darkish\CategoryBundle\Entity\RecordMainTree $mainrecords)
    {
        $this->mainrecords->removeElement($mainrecords);
    }

    /**
     * Get mainrecords
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMainrecords()
    {
        return $this->mainrecords;
    }

    /**
     * Set groupFilter
     *
     * @param boolean $groupFilter
     *
     * @return MainTree
     */
    public function setGroupFilter($groupFilter)
    {
        $this->groupFilter = $groupFilter;

        return $this;
    }

    /**
     * Get groupFilter
     *
     * @return boolean
     */
    public function getGroupFilter()
    {
        return $this->groupFilter;
    }

    /**
     * Set recommendIds
     *
     * @param array $recommendIds
     *
     * @return MainTree
     */
    public function setRecommendIds($recommendIds)
    {
        $this->recommendIds = $recommendIds;

        return $this;
    }

    /**
     * Get recommendIds
     *
     * @return array
     */
    public function getRecommendIds()
    {
        return $this->recommendIds;
    }
}
