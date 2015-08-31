<?php

namespace Darkish\WebsiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * WebMainTree
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Darkish\WebsiteBundle\Entity\WebMainTreeRepository")
 */
class WebMainTree
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
     * @ORM\Column(name="UpTreeIndex", type="string", length=255)
     */
    private $upTreeIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="TreeIndex", type="string", length=255)
     */
    private $treeIndex;

    /**
     * @var integer
     *
     * @ORM\Column(name="Sort", type="integer")
     */
    private $sort;

    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="SubTitle", type="string", length=255)
     */
    private $subTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="ReferenceTreeIndex", type="string", length=255)
     */
    private $referenceTreeIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="RecommendTreeIndex", type="string", length=255)
     */
    private $recommendTreeIndex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="RandomListSort", type="boolean")
     */
    private $randomListSort;

    /**
     * @var string
     *
     * @ORM\Column(name="IntroRecNumber", type="string", length=255)
     */
    private $introRecNumber;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowInfoKey", type="boolean")
     */
    private $showInfoKey;

    /**
     * @var string
     *
     * @ORM\Column(name="InfoKeyTitle", type="string", length=255)
     */
    private $infoKeyTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="InfoReference", type="string", length=255)
     */
    private $infoReference;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowBrandsKey", type="boolean")
     */
    private $showBrandsKey;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowMessagesKey", type="boolean")
     */
    private $showMessagesKey;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowSponsorBox", type="boolean")
     */
    private $showSponsorBox;

    /**
     * @var string
     *
     * @ORM\Column(name="SponsorGroup", type="string", length=255)
     */
    private $sponsorGroup;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowCenters", type="boolean")
     */
    private $showCenters;

    /**
     * @var integer
     *
     * @ORM\Column(name="CentersGroupIndex", type="integer")
     */
    private $centersGroupIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="DbaseType", type="string", length=255)
     */
    private $dbaseType;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowDbaseKey", type="boolean")
     */
    private $showDbaseKey;

    /**
     * @var string
     *
     * @ORM\Column(name="DbaseKeyTitle", type="string", length=255)
     */
    private $dbaseKeyTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="IconFileName", type="string", length=255)
     */
    private $iconFileName;

    /**
     * @var string
     *
     * @ORM\Column(name="FontColor", type="string", length=255)
     */
    private $fontColor;

    /**
     * @var string
     *
     * @ORM\Column(name="BackColor", type="string", length=255)
     */
    private $backColor;

    /**
     * @var boolean
     *
     * @ORM\Column(name="HiddenTree", type="boolean")
     */
    private $hiddenTree;

    /**
     * @var array
     * @ORM\Column(name="TreesIds", type="json_array")
     */
    private $treesIds;


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
     *
     * @return WebMainTree
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
     *
     * @return WebMainTree
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
     *
     * @return WebMainTree
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
     *
     * @return WebMainTree
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
     *
     * @return WebMainTree
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
     * Set referenceTreeIndex
     *
     * @param string $referenceTreeIndex
     *
     * @return WebMainTree
     */
    public function setReferenceTreeIndex($referenceTreeIndex)
    {
        $this->referenceTreeIndex = $referenceTreeIndex;

        return $this;
    }

    /**
     * Get referenceTreeIndex
     *
     * @return string
     */
    public function getReferenceTreeIndex()
    {
        return $this->referenceTreeIndex;
    }

    /**
     * Set recommendTreeIndex
     *
     * @param string $recommendTreeIndex
     *
     * @return WebMainTree
     */
    public function setRecommendTreeIndex($recommendTreeIndex)
    {
        $this->recommendTreeIndex = $recommendTreeIndex;

        return $this;
    }

    /**
     * Get recommendTreeIndex
     *
     * @return string
     */
    public function getRecommendTreeIndex()
    {
        return $this->recommendTreeIndex;
    }

    /**
     * Set randomListSort
     *
     * @param boolean $randomListSort
     *
     * @return WebMainTree
     */
    public function setRandomListSort($randomListSort)
    {
        $this->randomListSort = $randomListSort;

        return $this;
    }

    /**
     * Get randomListSort
     *
     * @return boolean
     */
    public function getRandomListSort()
    {
        return $this->randomListSort;
    }

    /**
     * Set introRecNumber
     *
     * @param string $introRecNumber
     *
     * @return WebMainTree
     */
    public function setIntroRecNumber($introRecNumber)
    {
        $this->introRecNumber = $introRecNumber;

        return $this;
    }

    /**
     * Get introRecNumber
     *
     * @return string
     */
    public function getIntroRecNumber()
    {
        return $this->introRecNumber;
    }

    /**
     * Set showInfoKey
     *
     * @param boolean $showInfoKey
     *
     * @return WebMainTree
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
     *
     * @return WebMainTree
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
     * Set infoReference
     *
     * @param string $infoReference
     *
     * @return WebMainTree
     */
    public function setInfoReference($infoReference)
    {
        $this->infoReference = $infoReference;

        return $this;
    }

    /**
     * Get infoReference
     *
     * @return string
     */
    public function getInfoReference()
    {
        return $this->infoReference;
    }

    /**
     * Set showBrandsKey
     *
     * @param boolean $showBrandsKey
     *
     * @return WebMainTree
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
     *
     * @return WebMainTree
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
     *
     * @return WebMainTree
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
     * @param string $sponsorGroup
     *
     * @return WebMainTree
     */
    public function setSponsorGroup($sponsorGroup)
    {
        $this->sponsorGroup = $sponsorGroup;

        return $this;
    }

    /**
     * Get sponsorGroup
     *
     * @return string
     */
    public function getSponsorGroup()
    {
        return $this->sponsorGroup;
    }

    /**
     * Set showCenters
     *
     * @param boolean $showCenters
     *
     * @return WebMainTree
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
     * Set centersGroupIndex
     *
     * @param integer $centersGroupIndex
     *
     * @return WebMainTree
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
     * Set dbaseType
     *
     * @param string $dbaseType
     *
     * @return WebMainTree
     */
    public function setDbaseType($dbaseType)
    {
        $this->dbaseType = $dbaseType;

        return $this;
    }

    /**
     * Get dbaseType
     *
     * @return string
     */
    public function getDbaseType()
    {
        return $this->dbaseType;
    }

    /**
     * Set showDbaseKey
     *
     * @param boolean $showDbaseKey
     *
     * @return WebMainTree
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
     *
     * @return WebMainTree
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
     * Set iconFileName
     *
     * @param string $iconFileName
     *
     * @return WebMainTree
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
     * Set fontColor
     *
     * @param string $fontColor
     *
     * @return WebMainTree
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
     *
     * @return WebMainTree
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
     * Set hiddenTree
     *
     * @param boolean $hiddenTree
     *
     * @return WebMainTree
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
     * Set treesIds
     *
     * @param array $treesIds
     *
     * @return WebMainTree
     */
    public function setTreesIds($treesIds)
    {
        $this->treesIds = $treesIds;

        return $this;
    }

    /**
     * Get treesIds
     *
     * @return array
     */
    public function getTreesIds()
    {
        return $this->treesIds;
    }
}
