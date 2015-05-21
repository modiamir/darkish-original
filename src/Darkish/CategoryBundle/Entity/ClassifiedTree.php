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
 * ClassifiedTree
 *
 * @ORM\Table(name="classifiedtree")
 * @ORM\Entity
 */
class ClassifiedTree
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"list", "details", "classified.details", "api.list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="up_tree_index", type="string", length=255, nullable=true)
     * @Groups({"list", "details", "classified.details"})
     */
    private $upTreeIndex;
    
    /**
     *
     * @Groups({"list", "details", "classified.details"})
     */
    private $parentTreeTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="tree_index", type="string", length=255, nullable=true)
     * @Groups({"list", "details", "classified.details", "api.list"})
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
     * @Groups({"list", "details", "classified.details", "api.list"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="sub_title", type="string", length=255, nullable=true)
     * @Groups({"list", "details", "classified.details"})
     */
    private $subTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="back_key_title", type="string", length=255, nullable=true)
     * @Groups({"list", "details", "classified.details"})
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
     * @var string
     *
     * @ORM\Column(name="icon_set_files_name", type="string", nullable=true)
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
     * @var \Doctrine\Common\Collections\ArrayCollection $classified
     *
     * @ORM\ManyToMany(targetEntity="Darkish\CategoryBundle\Entity\Classified", mappedBy="trees")
     */
    protected $classified;

    /**
     * @ORM\OneToMany(targetEntity="ClassifiedClassifiedTree", mappedBy="tree")
     **/
    private $mainclassifieds;

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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @param strj g $iconSetFilesName
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
     * @return ClassifiedTree
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
        $this->classified = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add classified
     *
     * @param \Darkish\CategoryBundle\Entity\Classified $classified
     * @return ClassifiedTree
     */
    public function addClassified(\Darkish\CategoryBundle\Entity\Classified $classified)
    {
        $this->classified[] = $classified;

        return $this;
    }

    /**
     * Remove classified
     *
     * @param \Darkish\CategoryBundle\Entity\Classified $classified
     */
    public function removeClassified(\Darkish\CategoryBundle\Entity\Classified $classified)
    {
        $this->classified->removeElement($classified);
    }

    /**
     * Get classified
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassified()
    {
        return $this->classified;
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
     * @Groups({"list", "details", "classified.details"})
     */
    public function getParentTreeTitle() {
        return $this->parentTreeTitle;
    }

    /**
     * Add mainclassifieds
     *
     * @param \Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree $mainclassifieds
     * @return ClassifiedTree
     */
    public function addMainclassified(\Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree $mainclassifieds)
    {
        $this->mainclassifieds[] = $mainclassifieds;

        return $this;
    }

    /**
     * Remove mainclassifieds
     *
     * @param \Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree $mainclassifieds
     */
    public function removeMainclassified(\Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree $mainclassifieds)
    {
        $this->mainclassifieds->removeElement($mainclassifieds);
    }

    /**
     * Get mainclassifieds
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMainclassifieds()
    {
        return $this->mainclassifieds;
    }
}
