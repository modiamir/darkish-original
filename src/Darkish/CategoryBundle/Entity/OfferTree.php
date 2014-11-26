<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfferTree
 *
 * @ORM\Table(name="offertree")
 * @ORM\Entity
 */
class OfferTree
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
     * @ORM\Column(name="up_tree_index", type="string", length=255, nullable=true)
     */
    private $upTreeIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="tree_index", type="string", length=255, nullable=true)
     */
    private $treeIndex;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer", nullable=true)
     */
    private $sort;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_title", type="string", length=255, nullable=true)
     */
    private $subTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="back_key_title", type="string", length=255, nullable=true)
     */
    private $backKeyTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="search_keywords", type="text", nullable=true)
     */
    private $searchKeywords;

    /**
     * @var boolean
     *
     * @ORM\Column(name="show_subtree_as_filter", type="boolean", nullable=true)
     */
    private $showSubtreeAsFilter;

    /**
     * @var boolean
     *
     * @ORM\Column(name="show_sponsor_box", type="boolean", nullable=true)
     */
    private $showSponsorBox;

    /**
     * @var string
     *
     * @ORM\Column(name="sponsor_group", type="string", length=255, nullable=true)
     */
    private $sponsorGroup;

    /**
     * @var string
     *
     * @ORM\Column(name="icon_file_name", type="string", length=255, nullable=true)
     */
    private $iconFileName;

    /**
     * @var array
     *
     * @ORM\Column(name="icon_set_files_name", type="array", nullable=true)
     */
    private $iconSetFilesName;

    /**
     * @var string
     *
     * @ORM\Column(name="font_color", type="string", length=255, nullable=true)
     */
    private $fontColor;

    /**
     * @var string
     *
     * @ORM\Column(name="back_color", type="string", length=255, nullable=true)
     */
    private $backColor;

    /**
     * @var boolean
     *
     * @ORM\Column(name="sub_pic_show", type="boolean", nullable=true)
     */
    private $subPicShow;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_background", type="string", length=255, nullable=true)
     */
    private $subBackground;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_unit_height_scale", type="string", length=255, nullable=true)
     */
    private $subUnitHeightScale;

    /**
     * @var boolean
     *
     * @ORM\Column(name="hidden_tree", type="boolean", nullable=true)
     */
    private $hiddenTree;


    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="offertree")
     */
    //protected  $newsList;

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
     * @return NewsTree
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
     * @return NewsTree
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
     * @return NewsTree
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
     * @return NewsTree
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
     * @return NewsTree
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
     * @return NewsTree
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
     * @return NewsTree
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
     * Set showSubtreeAsFilter
     *
     * @param boolean $showSubtreeAsFilter
     * @return NewsTree
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
     * Set showSponsorBox
     *
     * @param boolean $showSponsorBox
     * @return NewsTree
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
     * @return NewsTree
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
     * Set iconFileName
     *
     * @param string $iconFileName
     * @return NewsTree
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
     * @param array $iconSetFilesName
     * @return NewsTree
     */
    public function setIconSetFilesName($iconSetFilesName)
    {
        $this->iconSetFilesName = $iconSetFilesName;

        return $this;
    }

    /**
     * Get iconSetFilesName
     *
     * @return array 
     */
    public function getIconSetFilesName()
    {
        return $this->iconSetFilesName;
    }

    /**
     * Set fontColor
     *
     * @param string $fontColor
     * @return NewsTree
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
     * @return NewsTree
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
     * @return NewsTree
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
     * @return NewsTree
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
     * Set subUnitHeightScale
     *
     * @param string $subUnitHeightScale
     * @return NewsTree
     */
    public function setSubUnitHeightScale($subUnitHeightScale)
    {
        $this->subUnitHeightScale = $subUnitHeightScale;

        return $this;
    }

    /**
     * Get subUnitHeightScale
     *
     * @return string 
     */
    public function getSubUnitHeightScale()
    {
        return $this->subUnitHeightScale;
    }

    /**
     * Set hiddenTree
     *
     * @param boolean $hiddenTree
     * @return NewsTree
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

    public function __construct()
    {
        $this->newsList = new ArrayCollection();
    }



    /**
     * Add newsList
     *
     * @param \Darkish\CategoryBundle\Entity\News $newsList
     * @return NewsTree
     */
    public function addNewsList(\Darkish\CategoryBundle\Entity\News $newsList)
    {
        $this->newsList[] = $newsList;

        return $this;
    }

    /**
     * Remove newsList
     *
     * @param \Darkish\CategoryBundle\Entity\News $newsList
     */
    public function removeNewsList(\Darkish\CategoryBundle\Entity\News $newsList)
    {
        $this->newsList->removeElement($newsList);
    }

    /**
     * Get newsList
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNewsList()
    {
        return $this->newsList;
    }
}