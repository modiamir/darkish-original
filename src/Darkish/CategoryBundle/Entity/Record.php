<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * Record
 *
 * @ORM\Table(name="record")
 * @ORM\Entity(repositoryClass="Darkish\CategoryBundle\Entity\RecordRepository")
 */
class Record
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"record.list", "record.details"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="record_number", type="string", length=255, unique=true)
     * @Groups({"record.list", "record.details"})
     */
    private $recordNumber;


    /**
     * @var string
     *
     * @ORM\Column(name="Title", type="string", length=255)
     * @Groups({"record.list", "record.details"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="SubTitle", type="string", length=255, nullable=true)
     * @Groups({"record.list", "record.details"})
     *
     */
    private $subTitle;

    /**
     * @var integer
     *
     * @ORM\Column(name="Owner", type="string", nullable=true)
     * @Groups({"record.details"})
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="LegalName", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $legalName;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Center", inversedBy="records")
     * @ORM\JoinColumn(name="CenterIndex", referencedColumnName="id")
     * @Groups({"record.details"})
     */
    private $centerIndex;



    /**
     * @var string
     *
     * @ORM\Column(name="CenterFloor", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $centerFloor;

    /**
     * @var string
     *
     * @ORM\Column(name="CenterUnitNumber", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $centerUnitNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="AreaIndex", type="integer", nullable=true)
     * @Groups({"record.details"})
     */
    private $areaIndex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="MessageEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $messageEnable;

    /**
     * @var string
     *
     * @ORM\Column(name="MessageText", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $messageText;

    /**
     * @var string
     *
     * @ORM\Column(name="MessageValidityText", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $messageValidityText;

    /**
     * @var integer
     *
     * @ORM\Column(name="safarsazTypeIndex", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="SafarsazType", inversedBy="records")
     * @ORM\JoinColumn(name="safarsazTypeIndex", referencedColumnName="id")
     * @Groups({"record.details"})
     */
    private $safarsazTypeIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="SafarsazRank", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $safarsazRank;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumber", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $telNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="FaxNumber", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $faxNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="MobileNumbers", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $mobileNumbers;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Website", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $website;

    /**
     * @var string
     *
     * @ORM\Column(name="Address", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="Longitude", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="Latitude", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="Reserved1", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $reserved1;

    /**
     * @var string
     *
     * @ORM\Column(name="Reserved2", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $reserved2;

    /**
     * @var boolean
     *
     * @ORM\Column(name="BrandEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $brandEnable;

    /**
     * @var string
     *
     * @ORM\Column(name="ListRank", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $listRank;

    /**
     * @var string
     *
     * @ORM\Column(name="MOpeningHours", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $mOpeningHours;

    /**
     * @var string
     *
     * @ORM\Column(name="AOpeningHours", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $aOpeningHours;

    /**
     * @var string
     *
     * @ORM\Column(name="WorkingDays", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $workingDays;

    /**
     * @var string
     *
     * @ORM\Column(name="SearchKeywords", type="text", nullable=true)
     * @Groups({"record.details"})
     */
    private $searchKeywords;

    /**
     * @var string
     *
     * @ORM\Column(name="CreationDate", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="LastUpdate", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $lastUpdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="FavoriteEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $favoriteEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="LikeEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $likeEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="SendSmsEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $sendSmsEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="InfoKeyEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $infoKeyEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="CommentEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $commentEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="OnlyHtml", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $onlyHtml;

    /**
     * @var boolean
     *
     * @ORM\Column(name="OnlineEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $onlineEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="DbaseEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $dbaseEnable;

    /**
     * @var string
     *
     * @ORM\Column(name="DbaseTypeIndex", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $dbaseTypeIndex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="BulkSmsEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $bulkSmsEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Audio", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $audio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Video", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $video;

    /**
     * @var boolean
     *
     * @ORM\Column(name="OnlineMarket", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $onlineMarket;

    /**
     * @var boolean
     *
     * @ORM\Column(name="OnlineTicket", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $onlineTicket;

    /**
     * @var integer
     *
     * @ORM\Column(name="VisitCount", type="integer", nullable=true)
     * @Groups({"record.details"})
     */
    private $visitCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="FavoriteCount", type="integer", nullable=true)
     * @Groups({"record.details"})
     */
    private $favoriteCount;

    /**
     * @var integer
     *
     * @ORM\Column(name="LikeCount", type="integer", nullable=true)
     * @Groups({"record.details"})
     */
    private $likeCount;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Verify", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $verify;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $trees
     *
     * @Groups({"record.details"})
     *
     * @ORM\ManyToMany(targetEntity="Darkish\CategoryBundle\Entity\MainTree", inversedBy="records")
     * @ORM\JoinTable(name="records_maintrees",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="maintree_id", referencedColumnName="id")}
     *      )
     **/
    private $trees;




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
     * Set title
     *
     * @param string $title
     * @return Record
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
     * @return Record
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
     * Set owner
     *
     * @param string $owner
     * @return Record
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return string 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Set legalName
     *
     * @param string $legalName
     * @return Record
     */
    public function setLegalName($legalName)
    {
        $this->legalName = $legalName;

        return $this;
    }

    /**
     * Get legalName
     *
     * @return string 
     */
    public function getLegalName()
    {
        return $this->legalName;
    }

    

    

    /**
     * Set centerFloor
     *
     * @param string $centerFloor
     * @return Record
     */
    public function setCenterFloor($centerFloor)
    {
        $this->centerFloor = $centerFloor;

        return $this;
    }

    /**
     * Get centerFloor
     *
     * @return string 
     */
    public function getCenterFloor()
    {
        return $this->centerFloor;
    }

    /**
     * Set centerUnitNumber
     *
     * @param string $centerUnitNumber
     * @return Record
     */
    public function setCenterUnitNumber($centerUnitNumber)
    {
        $this->centerUnitNumber = $centerUnitNumber;

        return $this;
    }

    /**
     * Get centerUnitNumber
     *
     * @return string 
     */
    public function getCenterUnitNumber()
    {
        return $this->centerUnitNumber;
    }

    /**
     * Set areaIndex
     *
     * @param integer $areaIndex
     * @return Record
     */
    public function setAreaIndex($areaIndex)
    {
        $this->areaIndex = $areaIndex;

        return $this;
    }

    /**
     * Get areaIndex
     *
     * @return integer 
     */
    public function getAreaIndex()
    {
        return $this->areaIndex;
    }

    /**
     * Set messageEnable
     *
     * @param boolean $messageEnable
     * @return Record
     */
    public function setMessageEnable($messageEnable)
    {
        $this->messageEnable = $messageEnable;

        return $this;
    }

    /**
     * Get messageEnable
     *
     * @return boolean 
     */
    public function getMessageEnable()
    {
        return $this->messageEnable;
    }

    /**
     * Set messageText
     *
     * @param string $messageText
     * @return Record
     */
    public function setMessageText($messageText)
    {
        $this->messageText = $messageText;

        return $this;
    }

    /**
     * Get messageText
     *
     * @return string 
     */
    public function getMessageText()
    {
        return $this->messageText;
    }

    /**
     * Set messageValidityText
     *
     * @param string $messageValidityText
     * @return Record
     */
    public function setMessageValidityText($messageValidityText)
    {
        $this->messageValidityText = $messageValidityText;

        return $this;
    }

    /**
     * Get messageValidityText
     *
     * @return string 
     */
    public function getMessageValidityText()
    {
        return $this->messageValidityText;
    }

    

    

    /**
     * Set telNumber
     *
     * @param string $telNumber
     * @return Record
     */
    public function setTelNumber($telNumber)
    {
        $this->telNumber = $telNumber;

        return $this;
    }

    /**
     * Get telNumber
     *
     * @return string 
     */
    public function getTelNumber()
    {
        return $this->telNumber;
    }

    /**
     * Set faxNumber
     *
     * @param string $faxNumber
     * @return Record
     */
    public function setFaxNumber($faxNumber)
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    /**
     * Get faxNumber
     *
     * @return string 
     */
    public function getFaxNumber()
    {
        return $this->faxNumber;
    }

    /**
     * Set mobileNumbers
     *
     * @param string $mobileNumbers
     * @return Record
     */
    public function setMobileNumbers($mobileNumbers)
    {
        $this->mobileNumbers = $mobileNumbers;

        return $this;
    }

    /**
     * Get mobileNumbers
     *
     * @return string 
     */
    public function getMobileNumbers()
    {
        return $this->mobileNumbers;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Record
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return Record
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Record
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     * @return Record
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
     * @return Record
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
     * Set reserved1
     *
     * @param string $reserved1
     * @return Record
     */
    public function setReserved1($reserved1)
    {
        $this->reserved1 = $reserved1;

        return $this;
    }

    /**
     * Get reserved1
     *
     * @return string 
     */
    public function getReserved1()
    {
        return $this->reserved1;
    }

    /**
     * Set reserved2
     *
     * @param string $reserved2
     * @return Record
     */
    public function setReserved2($reserved2)
    {
        $this->reserved2 = $reserved2;

        return $this;
    }

    /**
     * Get reserved2
     *
     * @return string 
     */
    public function getReserved2()
    {
        return $this->reserved2;
    }

    /**
     * Set brandEnable
     *
     * @param boolean $brandEnable
     * @return Record
     */
    public function setBrandEnable($brandEnable)
    {
        $this->brandEnable = $brandEnable;

        return $this;
    }

    /**
     * Get brandEnable
     *
     * @return boolean 
     */
    public function getBrandEnable()
    {
        return $this->brandEnable;
    }

    /**
     * Set listRank
     *
     * @param string $listRank
     * @return Record
     */
    public function setListRank($listRank)
    {
        $this->listRank = $listRank;

        return $this;
    }

    /**
     * Get listRank
     *
     * @return string 
     */
    public function getListRank()
    {
        return $this->listRank;
    }

    /**
     * Set mOpeningHours
     *
     * @param string $mOpeningHours
     * @return Record
     */
    public function setMOpeningHours($mOpeningHours)
    {
        $this->mOpeningHours = $mOpeningHours;

        return $this;
    }

    /**
     * Get mOpeningHours
     *
     * @return string 
     */
    public function getMOpeningHours()
    {
        return $this->mOpeningHours;
    }

    /**
     * Set aOpeningHours
     *
     * @param string $aOpeningHours
     * @return Record
     */
    public function setAOpeningHours($aOpeningHours)
    {
        $this->aOpeningHours = $aOpeningHours;

        return $this;
    }

    /**
     * Get aOpeningHours
     *
     * @return string 
     */
    public function getAOpeningHours()
    {
        return $this->aOpeningHours;
    }

    /**
     * Set workingDays
     *
     * @param string $workingDays
     * @return Record
     */
    public function setWorkingDays($workingDays)
    {
        $this->workingDays = $workingDays;

        return $this;
    }

    /**
     * Get workingDays
     *
     * @return string 
     */
    public function getWorkingDays()
    {
        return $this->workingDays;
    }

    /**
     * Set searchKeywords
     *
     * @param string $searchKeywords
     * @return Record
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
     * Set creationDate
     *
     * @param string $creationDate
     * @return Record
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return string 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastUpdate
     *
     * @param string $lastUpdate
     * @return Record
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return string 
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set favoriteEnable
     *
     * @param boolean $favoriteEnable
     * @return Record
     */
    public function setFavoriteEnable($favoriteEnable)
    {
        $this->favoriteEnable = $favoriteEnable;

        return $this;
    }

    /**
     * Get favoriteEnable
     *
     * @return boolean 
     */
    public function getFavoriteEnable()
    {
        return $this->favoriteEnable;
    }

    /**
     * Set likeEnable
     *
     * @param boolean $likeEnable
     * @return Record
     */
    public function setLikeEnable($likeEnable)
    {
        $this->likeEnable = $likeEnable;

        return $this;
    }

    /**
     * Get likeEnable
     *
     * @return boolean 
     */
    public function getLikeEnable()
    {
        return $this->likeEnable;
    }

    /**
     * Set sendSmsEnable
     *
     * @param boolean $sendSmsEnable
     * @return Record
     */
    public function setSendSmsEnable($sendSmsEnable)
    {
        $this->sendSmsEnable = $sendSmsEnable;

        return $this;
    }

    /**
     * Get sendSmsEnable
     *
     * @return boolean 
     */
    public function getSendSmsEnable()
    {
        return $this->sendSmsEnable;
    }

    /**
     * Set infoKeyEnable
     *
     * @param boolean $infoKeyEnable
     * @return Record
     */
    public function setInfoKeyEnable($infoKeyEnable)
    {
        $this->infoKeyEnable = $infoKeyEnable;

        return $this;
    }

    /**
     * Get infoKeyEnable
     *
     * @return boolean 
     */
    public function getInfoKeyEnable()
    {
        return $this->infoKeyEnable;
    }

    /**
     * Set commentEnable
     *
     * @param boolean $commentEnable
     * @return Record
     */
    public function setCommentEnable($commentEnable)
    {
        $this->commentEnable = $commentEnable;

        return $this;
    }

    /**
     * Get commentEnable
     *
     * @return boolean 
     */
    public function getCommentEnable()
    {
        return $this->commentEnable;
    }

    /**
     * Set onlyHtml
     *
     * @param boolean $onlyHtml
     * @return Record
     */
    public function setOnlyHtml($onlyHtml)
    {
        $this->onlyHtml = $onlyHtml;

        return $this;
    }

    /**
     * Get onlyHtml
     *
     * @return boolean 
     */
    public function getOnlyHtml()
    {
        return $this->onlyHtml;
    }

    /**
     * Set onlineEnable
     *
     * @param boolean $onlineEnable
     * @return Record
     */
    public function setOnlineEnable($onlineEnable)
    {
        $this->onlineEnable = $onlineEnable;

        return $this;
    }

    /**
     * Get onlineEnable
     *
     * @return boolean 
     */
    public function getOnlineEnable()
    {
        return $this->onlineEnable;
    }

    /**
     * Set dbaseEnable
     *
     * @param boolean $dbaseEnable
     * @return Record
     */
    public function setDbaseEnable($dbaseEnable)
    {
        $this->dbaseEnable = $dbaseEnable;

        return $this;
    }

    /**
     * Get dbaseEnable
     *
     * @return boolean 
     */
    public function getDbaseEnable()
    {
        return $this->dbaseEnable;
    }

    /**
     * Set dbaseTypeIndex
     *
     * @param string $dbaseTypeIndex
     * @return Record
     */
    public function setDbaseTypeIndex($dbaseTypeIndex)
    {
        $this->dbaseTypeIndex = $dbaseTypeIndex;

        return $this;
    }

    /**
     * Get dbaseTypeIndex
     *
     * @return string 
     */
    public function getDbaseTypeIndex()
    {
        return $this->dbaseTypeIndex;
    }

    /**
     * Set bulkSmsEnable
     *
     * @param boolean $bulkSmsEnable
     * @return Record
     */
    public function setBulkSmsEnable($bulkSmsEnable)
    {
        $this->bulkSmsEnable = $bulkSmsEnable;

        return $this;
    }

    /**
     * Get bulkSmsEnable
     *
     * @return boolean 
     */
    public function getBulkSmsEnable()
    {
        return $this->bulkSmsEnable;
    }

    /**
     * Set audio
     *
     * @param boolean $audio
     * @return Record
     */
    public function setAudio($audio)
    {
        $this->audio = $audio;

        return $this;
    }

    /**
     * Get audio
     *
     * @return boolean 
     */
    public function getAudio()
    {
        return $this->audio;
    }

    /**
     * Set video
     *
     * @param boolean $video
     * @return Record
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return boolean 
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * Set onlineMarket
     *
     * @param boolean $onlineMarket
     * @return Record
     */
    public function setOnlineMarket($onlineMarket)
    {
        $this->onlineMarket = $onlineMarket;

        return $this;
    }

    /**
     * Get onlineMarket
     *
     * @return boolean 
     */
    public function getOnlineMarket()
    {
        return $this->onlineMarket;
    }

    /**
     * Set onlineTicket
     *
     * @param boolean $onlineTicket
     * @return Record
     */
    public function setOnlineTicket($onlineTicket)
    {
        $this->onlineTicket = $onlineTicket;

        return $this;
    }

    /**
     * Get onlineTicket
     *
     * @return boolean 
     */
    public function getOnlineTicket()
    {
        return $this->onlineTicket;
    }

    /**
     * Set visitCount
     *
     * @param integer $visitCount
     * @return Record
     */
    public function setVisitCount($visitCount)
    {
        $this->visitCount = $visitCount;

        return $this;
    }

    /**
     * Get visitCount
     *
     * @return integer 
     */
    public function getVisitCount()
    {
        return $this->visitCount;
    }

    /**
     * Set favoriteCount
     *
     * @param integer $favoriteCount
     * @return Record
     */
    public function setFavoriteCount($favoriteCount)
    {
        $this->favoriteCount = $favoriteCount;

        return $this;
    }

    /**
     * Get favoriteCount
     *
     * @return integer 
     */
    public function getFavoriteCount()
    {
        return $this->favoriteCount;
    }

    /**
     * Set likeCount
     *
     * @param integer $likeCount
     * @return Record
     */
    public function setLikeCount($likeCount)
    {
        $this->likeCount = $likeCount;

        return $this;
    }

    /**
     * Get likeCount
     *
     * @return integer 
     */
    public function getLikeCount()
    {
        return $this->likeCount;
    }

    /**
     * Set verify
     *
     * @param boolean $verify
     * @return Record
     */
    public function setVerify($verify)
    {
        $this->verify = $verify;

        return $this;
    }

    /**
     * Get verify
     *
     * @return boolean 
     */
    public function getVerify()
    {
        return $this->verify;
    }

    /**
     * Set recordNumber
     *
     * @param string $recordNumber
     * @return Record
     */
    public function setRecordNumber($recordNumber)
    {
        $this->recordNumber = $recordNumber;

        return $this;
    }

    /**
     * Get recordNumber
     *
     * @return string 
     */
    public function getRecordNumber()
    {
        return $this->recordNumber;
    }

    /**
     * Add trees
     *
     * @param \Darkish\CategoryBundle\Entity\MainTree $trees
     * @return Record
     */
    public function addTree(\Darkish\CategoryBundle\Entity\MainTree $tree)
    {
        $this->trees[] = $tree;

        return $this;
    }

    /**
     * Remove tree
     *
     * @param \Darkish\CategoryBundle\Entity\MainTree $tree
     */
    public function removeTree(\Darkish\CategoryBundle\Entity\MainTree $tree)
    {
        $this->trees->removeElement($tree);
    }

    /**
     * Get trees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrees()
    {
        return $this->trees;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trees = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set centerIndex
     *
     * @param \Darkish\CategoryBundle\Entity\Center $centerIndex
     * @return Record
     */
    public function setCenterIndex(\Darkish\CategoryBundle\Entity\Center $centerIndex = null)
    {
        $this->centerIndex = $centerIndex;
    
        return $this;
    }

    /**
     * Get centerIndex
     *
     * @return \Darkish\CategoryBundle\Entity\Center 
     */
    public function getCenterIndex()
    {
        return $this->centerIndex;
    }

    /**
     * Set safarsazTypeIndex
     *
     * @param integer $safarsazTypeIndex
     * @return Record
     */
    public function setSafarsazTypeIndex($safarsazTypeIndex)
    {
        $this->safarsazTypeIndex = $safarsazTypeIndex;
    
        return $this;
    }

    /**
     * Get safarsazTypeIndex
     *
     * @return integer 
     */
    public function getSafarsazTypeIndex()
    {
        return $this->safarsazTypeIndex;
    }

    /**
     * Set safarsazRank
     *
     * @param string $safarsazRank
     * @return Record
     */
    public function setSafarsazRank($safarsazRank)
    {
        $this->safarsazRank = $safarsazRank;
    
        return $this;
    }

    /**
     * Get safarsazRank
     *
     * @return string 
     */
    public function getSafarsazRank()
    {
        return $this->safarsazRank;
    }
}
