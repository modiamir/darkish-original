<?php

namespace Darkish\CategoryBundle\Entity;

use Darkish\CategoryBundle\Entity\Cache\StoreCache;
use Darkish\CategoryBundle\Entity\Interfaces\CanFavoriteInterface;
use Darkish\CategoryBundle\Entity\Interfaces\LikableInterface;
use Darkish\CategoryBundle\Entity\Interfaces\VisitableInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Record
 *
 * @ORM\Table(name="record")
 * @ORM\Entity(repositoryClass="Darkish\CategoryBundle\Entity\RecordRepository")
 */
class Record implements LikableInterface, CanFavoriteInterface, VisitableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"record.list", "record.details", "customer.list", "customer.details", "comment.details", "comment.list", "thread.list", "api.list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="record_number", type="string", length=255, unique=true)
     * @Groups({"record.list", "record.details", "customer.list", "customer.details", "api.list"})
     */
    private $recordNumber;


    /**
     * @var string
     * @ORM\Column(name="Title", type="string", length=255)
     * @Groups({"record.list", "record.details", "customer.list", "customer.details", "comment.details", "comment.list", "thread.list", "api.list"})
     * @Assert\Length(
     *      min = "2",
     *      max = "70",
     *      maxMessage = "طول عنوان نمیتواند بیشتر از {{ limit }} کاراکتر باشد",
     *      minMessage = "طول عنوان نمیتواند کمتر از {{ limit }} باشد"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="SubTitle", type="string", length=255, nullable=true)
     * @Groups({"record.list", "record.details", "customer.list", "customer.details", "api.list"})
     * @Assert\Length(
     *      min = "2",
     *      max = "70",
     *      maxMessage = "طول زیرعنوان نمیتواند بیشتر از {{ limit }} باشد",
     *      minMessage = "طول زیرعنوان نمیتواند کمتر از {{ limit }} باشد"
     * )
     *
     */
    private $subTitle;

    /**
     * @var string
     * @ORM\Column(name="EnglishTitle", type="string", length=255, nullable=true)
     * @Groups({"record.list", "record.details"})
     * @Assert\Length(
     *      min = "2",
     *      max = "70",
     *      maxMessage = "طول عنوان نمیتواند بیشتر از {{ limit }} کاراکتر باشد",
     *      minMessage = "طول عنوان نمیتواند کمتر از {{ limit }} باشد"
     * )
     */
    private $englishTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="EnglishSubTitle", type="string", length=255, nullable=true)
     * @Groups({"record.list", "record.details"})
     * @Assert\Length(
     *      min = "2",
     *      max = "70",
     *      maxMessage = "طول زیرعنوان نمیتواند بیشتر از {{ limit }} باشد",
     *      minMessage = "طول زیرعنوان نمیتواند کمتر از {{ limit }} باشد"
     * )
     *
     */
    private $englishSubTitle;

    /**
     * @var string
     * @ORM\Column(name="ArabicTitle", type="string", length=255, nullable=true)
     * @Groups({"record.list", "record.details"})
     * @Assert\Length(
     *      min = "2",
     *      max = "70",
     *      maxMessage = "طول عنوان نمیتواند بیشتر از {{ limit }} کاراکتر باشد",
     *      minMessage = "طول عنوان نمیتواند کمتر از {{ limit }} باشد"
     * )
     */
    private $arabicTitle;



    /**
     * @var string
     *
     * @ORM\Column(name="ArabicSubTitle", type="string", length=255, nullable=true)
     * @Groups({"record.list", "record.details"})
     * @Assert\Length(
     *      min = "2",
     *      max = "70",
     *      maxMessage = "طول زیرعنوان نمیتواند بیشتر از {{ limit }} باشد",
     *      minMessage = "طول زیرعنوان نمیتواند کمتر از {{ limit }} باشد"
     * )
     *
     */
    private $arabicSubTitle;

    /**
     * @var string
     * @ORM\Column(name="TurkishTitle", type="string", length=255, nullable=true)
     * @Groups({"record.list", "record.details"})
     * @Assert\Length(
     *      min = "2",
     *      max = "70",
     *      maxMessage = "طول عنوان نمیتواند بیشتر از {{ limit }} کاراکتر باشد",
     *      minMessage = "طول عنوان نمیتواند کمتر از {{ limit }} باشد"
     * )
     */
    private $turkishTitle;

    /**
     * @var string
     *
     * @ORM\Column(name="TurkishSubTitle", type="string", length=255, nullable=true)
     * @Groups({"record.list", "record.details"})
     * @Assert\Length(
     *      min = "2",
     *      max = "70",
     *      maxMessage = "طول زیرعنوان نمیتواند بیشتر از {{ limit }} باشد",
     *      minMessage = "طول زیرعنوان نمیتواند کمتر از {{ limit }} باشد"
     * )
     *
     */
    private $turkishSubTitle;

    /**
     * @var integer
     *
     * @ORM\Column(name="Owner", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="OwnerPhone", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $ownerPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="OwnerMail", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $ownerMail;

    /**
     * @var integer
     *
     * @ORM\Column(name="Manager", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $manager;

    /**
     * @var string
     *
     * @ORM\Column(name="ManagerPhone", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $managerPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="ManagerMail", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $managerMail;

    /**
     * @var string
     *
     * @ORM\Column(name="LegalName", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $legalName;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Center", inversedBy="records")
     * @ORM\JoinColumn(name="CenterIndex", referencedColumnName="id")
     * @Groups({"record.details", "api.list"})
     */
    private $centerIndex;



    /**
     * @var string
     *
     * @ORM\Column(name="CenterFloor", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $centerFloor;

    /**
     * @var string
     *
     * @ORM\Column(name="CenterUnitNumber", type="smallint", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $centerUnitNumber;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="records")
     * @ORM\JoinColumn(name="AreaIndex", referencedColumnName="id")
     * @Groups({"record.details"})
     */
    private $areaIndex;

    /**
     * @var boolean
     *
     * @ORM\Column(name="MessageEnable", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $messageEnable;

    /**
     * @var string
     *
     * @ORM\Column(name="MessageText", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $messageText;

    /**
     * @var string
     *
     * @ORM\Column(name="MessageInsertDate", type="string", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $messageInsertDate;


    /**
     * @var string
     *
     * @ORM\Column(name="MessageValidityDate", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $messageValidityDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="safarsaz", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     *
     */
    private $safarsaz;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="SafarsazType", inversedBy="records")
     * @ORM\JoinColumn(name="SafarsazTypeIndex", referencedColumnName="id")
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
     * @var boolean
     *
     * @ORM\Column(name="archive", type="boolean", nullable=true, options={"default" : false })
     * @Groups({"record.details"})
     */
    private $archive;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberOne", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberOneLabel", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberOneLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberTwo", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberTwoLabel", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberTwoLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberThree", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberThree;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberThreeLabel", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberThreeLabel;


    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberFour", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberFour;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberFourLabel", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberFourLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberFive", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberFive;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberFiveLabel", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberFiveLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberSix", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberSix;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberSixLabel", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberSixLabel;


    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberSeven", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberSeven;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberSevenLabel", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberSevenLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberEight", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberEight;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberEightLabel", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $telNumberEightLabel;

    /**
     * @var string
     *
     * @ORM\Column(name="FaxNumberOne", type="string",  nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $faxNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="FaxNumberTwo", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $faxNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="MobileNumberOne", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $mobileNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="MobileNumberTwo", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $mobileNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Website", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $website;
    
    /**
     * @var string
     *
     * @ORM\Column(name="SmsNumber", type="string",  nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $smsNumber;
    
    /**
     * @var string
     *
     * @ORM\Column(name="PostalCode", type="string",  nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $postalCode;

    /**
     * @var string
     *
     * @ORM\Column(name="Address", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
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
     * @ORM\Column(name="LatLongEncoded", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $latLongEncoded;

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
     * @Groups({"record.details", "api.body", "api.list"})
     */
    private $brandEnable;

    /**
     * @var string
     *
     * @ORM\Column(name="ListRank", type="integer", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $listRank;
    /**
     * @var string
     *
     * @ORM\Column(name="ListRankTwo", type="integer", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $listRankTwo;
    /**
     * @var string
     *
     * @ORM\Column(name="ListRankThree", type="integer", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $listRankThree;
    /**
     * @var string
     *
     * @ORM\Column(name="ListRankFour", type="integer", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $listRankFour;
    /**
     * @var string
     *
     * @ORM\Column(name="ListRankFive", type="integer", length=255, nullable=true)
     * @Groups({"record.details"})
     */
    private $listRankFive;

    /**
     * @var string
     *
     * @ORM\Column(name="MOpeningHoursFrom", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $mOpeningHoursFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="MOpeningHoursTo", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $mOpeningHoursTo;

    /**
     * @var string
     *
     * @ORM\Column(name="OpeningHours", type="string", nullable=true )
     * @Groups({"record.details", "api.list"})
     */
    private $openingHoursDesc;


    /**
     * @var string
     *
     * @ORM\Column(name="AOpeningHoursFrom", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $aOpeningHoursFrom;

    /**
     * @var string
     *
     * @ORM\Column(name="AOpeningHoursTo", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $aOpeningHoursTo;

    /**
     * @var string
     *
     * @ORM\Column(name="WorkingDays", type="string", length=255, nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $workingDays;

    /**
     * @var string
     *
     * @ORM\Column(name="WorkingDaysDesc", type="string", nullable=true )
     * @Groups({"record.details", "api.list"})
     */
    private $workingDaysDesc;


    /**
     * @var string
     *
     * @ORM\Column(name="SearchKeywords", type="text", nullable=true)
     * @Groups({"record.details"})
     */
    private $searchKeywords;

    /**
     * @var datetime
     *
     * @ORM\Column(name="CreationDate", type="datetime", nullable=false)
     * @Groups({"record.details", "api.list"})
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="LastUpdate", type="datetime", nullable=false)
     * @Groups({"record.details", "api.list"})
     */
    private $lastUpdate;
    
    /**
     * @var string
     *
     * @ORM\Column(name="HtmlLastUpdate", type="datetime", nullable=false)
     * @Groups({"record.details", "api.list"})
     */
    private $htmlLastUpdate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="FavoriteEnable", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $favoriteEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="LikeEnable", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $likeEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="ShowContactOnList", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $showContactOnList;

    /**
     * @var string
     * @ORM\Column(type="string", name="path", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $path;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="OnlyContactInformation", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $onlyContactInformation;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="SendSmsEnable", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $sendSmsEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="InfoKeyEnable", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $infoKeyEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="CommentEnable", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $commentEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="OnlyHtml", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $onlyHtml;

    /**
     * @var boolean
     *
     * @ORM\Column(name="OnlineEnable", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $onlineEnable;
    
    /**
     * @var string
     *
     * @ORM\Column(name="SellServicePageTitle", type="string", nullable=true)
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $sellServicePageTitle;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="SellServicePage", type="boolean", nullable=true, options={"default": 0})
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $sellServicePage;

    /**
     * @var boolean
     *
     * @ORM\Column(name="SellServicePageCustomer", type="boolean", nullable=true, options={"default": 0})
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $sellServicePageCustomer;

    /**
     * @ORM\Column(type="boolean", name="CustomerRegisterUsed", options={"default"=false})
     */
    private $customerRegisterUsed = false;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="DbaseEnable", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $dbaseEnable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="DbaseEnableCustomer", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $dbaseEnableCustomer;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="DbaseType", inversedBy="records")
     * @ORM\JoinColumn(name="DbaseTypeIndex", referencedColumnName="id")
     * @Groups({"record.details", "customer.details", "api.list", "api.body"})
     */
    private $dbaseTypeIndex;

    /**
     * @ORM\Column(name="DbaseDescription", type="text", nullable=true)
     */
    private $dbaseDescription;


    /**
     * @ORM\ManyToOne(targetEntity="ManagedFile", inversedBy="recordForDbasetBanner")
     * @ORM\JoinColumn(name="DbaseBanner", referencedColumnName="id")
     */
    private $dbaseBanner;


    /**
     * @var boolean
     *
     * @ORM\Column(name="BulkSmsEnable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $bulkSmsEnable;
    
    /**
     *
     * @var string
     * @ORM\Column(name="InfoOne", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $infoOne;
    
    /**
     *
     * @var string
     * @ORM\Column(name="InfoTwo", type="string", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $infoTwo;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="Hostelry", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $hostelry;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="Commentable", type="boolean", nullable=false, options={"default":1})
     * @Groups({"record.details", "record.list", "api.list"})
     */
    private $commentable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="CommentableCustomer", type="boolean", nullable=true, options={"default":1})
     * @Groups({"record.details", "record.list", "api.list"})
     */
    private $commentableCustomer;




    /**
     * @var string
     *
     * @ORM\Column(name="CommentDefaultState", type="integer", nullable=false, options={"default":3})
     * @Groups({"record.details"})
     */
    private $commentDefaultState;

    /**
     * @var string
     *
     * @ORM\Column(name="Body", type="text", nullable=true)
     * @Groups({"record.details", "api.body"})
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="WebBody", type="text", nullable=true)
     * @Groups({"record.details", "api.body"})
     */
    private $webBody;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Audio", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $audio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Video", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
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
     * @ORM\Column(name="MarketDescription", type="text", nullable=true)
     * @Groups({"api.store"})
     */
    private $marketDescription;


    /**
     * @ORM\ManyToOne(targetEntity="ManagedFile", inversedBy="recordForMarketBanner")
     * @ORM\JoinColumn(name="MarketBanner", referencedColumnName="id")
     * @Groups({"api.store"})
     */
    private $marketBanner;

    /**
     * @ORM\OneToMany(targetEntity="StoreGroup", mappedBy="record", cascade={"remove"})
     * @Groups({"api.store"})
     */
    private $marketGroups;

    /**
     * @ORM\ManyToOne(targetEntity="Template")
     * @ORM\JoinColumn(name="MarketTemplate", referencedColumnName="id")
     */
    private $marketTemplate;

    /**
     * @ORM\Column(name="MarketOnlineOrder", type="boolean", nullable=true, options={"default":false})
     */
    private $marketOnlineOrder;

    /**
     * @ORM\Column(name="MarketLastUpdate", type="datetime", nullable=true)
     * @Groups({"record.details", "record.list", "api.list"})
     */
    private $marketLastUpdate;

    /**
     * @ORM\Column(name="MarketLastCacheCreate", type="datetime", nullable=true)
     */
    private $marketLastCacheCreate;

    /**
     * @var StoreCache
     *
     * @ORM\OneToOne(targetEntity="Darkish\CategoryBundle\Entity\Cache\StoreCache", mappedBy="recordId", cascade={"remove"})
     */
    private $storeCache;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Darkish\CategoryBundle\Entity\Product", mappedBy="record", cascade={"remove"})
     */
    private $products;


    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Darkish\CategoryBundle\Entity\DBase", mappedBy="record", cascade={"remove"})
     */
    private $dbaseItems;


    /**
     * @var boolean
     *
     * @ORM\Column(name="TicketSeller", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $ticketSeller;

    /**
     * @var integer
     *
     * @ORM\Column(name="TicketSellerSort", type="integer", nullable=true)
     * @Groups({"record.details"})
     */
    private $ticketSellerSort;

    /**
     * @var boolean
     *
     * @ORM\Column(name="TicketServer", type="boolean", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $ticketServer;

    /**
     * @var integer
     *
     * @ORM\Column(name="TicketServerTreeSort", type="integer", nullable=true)
     * @Groups({"record.details"})
     */
    private $ticketServerTreeSort;

    /**
     * @ORM\ManyToOne(targetEntity="TicketServerTree", inversedBy="records")
     * @ORM\JoinColumn(name="ticketServerTree_id", referencedColumnName="id", onDelete="set null")
     * @Groups({"record.details"})
     */
    private $ticketServerTree;

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
     * @Groups({"record.details", "api.list"})
     */
    private $visitCount = 0;



    /**
     * @ORM\Column(name="CommentCount", type="integer", nullable=true, options={"default"=0})
     * @Groups({"record.details", "api.list"})
     */
    private $commentCount = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="FavoriteCount", type="integer", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $favoriteCount = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="LikeCount", type="integer", nullable=true)
     * @Groups({"record.details", "api.list"})
     */
    private $likeCount = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Active", type="boolean", nullable=false, options={"default":0})
     * @Groups({"record.details"})
     */
    private $active;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Verify", type="boolean", nullable=false, options={"default": 0})
     * @Groups({"record.details"})
     */
    private $verify;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ExpireDate", type="datetime", nullable=true)
     * @Groups({"record.details"})
     */
    private $expireDate;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="RecordAccessLevel")
     * @ORM\JoinColumn(name="AccessClass", referencedColumnName="id")
     * @Groups({"record.details"})
     */
    private $accessClass;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $trees
     *
     * @Groups({"record.details"})
     *
     * @ORM\ManyToMany(targetEntity="Darkish\CategoryBundle\Entity\MainTree", inversedBy="records")
     * @ORM\JoinTable(name="records_maintrees",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="maintree_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
    private $trees;

    /**
     * @ORM\OneToMany(targetEntity="RecordMainTree", mappedBy="record" , cascade={"remove"})
     * @Groups({"record.details", "api.list"})
     **/
    private $maintrees;
    
    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="records_images",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"record.details", "api.list"})
     **/
    private $images;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ManagedFile", inversedBy="iconForRecord")
     * @ORM\JoinColumn(name="IconIndex", referencedColumnName="id")
     * @Groups({"record.details", "api.list"})
     * 
     **/
    private $icon;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile", inversedBy="recordAsBodyImage")
     * @ORM\JoinTable(name="records_body_images",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"record.details"})
     **/
    private $bodyImages;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="records_videos",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"record.details", "api.list"})
     **/
    private $videos;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="records_body_videos",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"record.details"})
     **/
    private $bodyVideos;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="records_audios",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"record.details", "api.list"})
     **/
    private $audios;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="records_body_audios",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"record.details"})
     **/
    private $bodyAudios;
    
    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="records_body_docs",
     *      joinColumns={@ORM\JoinColumn(name="record_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"record.details"})
     **/
    private $bodyDocs;


    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="\Darkish\UserBundle\Entity\Operator", inversedBy="records")
     * @ORM\JoinColumn(name="UserId", referencedColumnName="id")
     * @Groups({"record.details"})
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="\Darkish\CommentBundle\Entity\RecordThread", mappedBy="target", cascade={"remove"})
     *  @Groups({"record.details"})
     */
    private $thread;

    /**
     *
     * @ORM\OneToMany(targetEntity="\Darkish\CustomerBundle\Entity\Customer", mappedBy="record", cascade={"remove"})
     * @Groups({"record.details", "api.list", "api.body"})
     */
    private $customers;


    /**
     * ORM\OneToMany(targetEntity="MessageThread", mappedBy="record")
     */
    private $messageThreads;


    /**
     * @ORM\ManyToMany(targetEntity="Darkish\UserBundle\Entity\Client", mappedBy="favoriteRecords", cascade={"persist"})
     * @Groups({"client.details", "record.details"})
     */
    private $clientsFavorited;

    /**
     * @ORM\Column(name="lastMessage", type="integer", nullable=true )
     */
    private $lastMessageRecieve;


    /**
     * @var boolean
     *
     * @ORM\Column(name="NonSearchable", type="boolean", nullable=true)
     * @Groups({"record.details"})
     */
    private $nonSearchable;


    /**
     * @ORM\Column(name="treejson", type="json_array", nullable=true)
     * @Groups({"record.details", "api.list"})
     **/
    private $treeJson;


    /**
     * @var
     * @ORM\Column(name="disable_recommendation", type="boolean", nullable=true, options={"default"=false})
     */
    private $disableRecommendation = false;



    /**
     * @ORM\Column(name="last_group_message", type="datetime", nullable=true)
     * @Groups({"record.details"})
     */
    private $lastGroupMessage;


    /**
     * @var booelan
     * @ORM\Column(name="is_checked_files", type="boolean", options={"default"=false})
     */
    private $isCheckedFiles = false;
    
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
     * Get formattedVisitCount
     *
     * @return integer 
     */
    public function getFormattedVisitCount()
    {
        return $this->getFormattedCount($this->visitCount);
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
     * Get formattedFavoriteCount
     *
     * @return integer 
     */
    public function getFormattedFavoriteCount()
    {
        return $this->getFormattedCount($this->favoriteCount);
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
     * Get formattedLikeCount
     *
     * @return integer 
     */
    public function getFormattedLikeCount()
    {
        return $this->getFormattedCount($this->likeCount);
    }

    public function getFormattedCount($count) {
        if(!$count) {
            return "0";
        } elseif($count <1000) {
            return "".$count;
        } else {
            $divided = (float)$count/1000;
            return round($divided, 1)."K";    
        }
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
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->audios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->videos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bodyImages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bodyVideos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bodyAudios = new \Doctrine\Common\Collections\ArrayCollection();
        $this->bodyDocs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->messageThreads = new \Doctrine\Common\Collections\ArrayCollection();
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

    /**
     * Set safarsaz
     *
     * @param boolean $safarsaz
     * @return Record
     */
    public function setSafarsaz($safarsaz)
    {
        $this->safarsaz = $safarsaz;
    
        return $this;
    }

    /**
     * Get safarsaz
     *
     * @return boolean 
     */
    public function getSafarsaz()
    {
        return $this->safarsaz;
    }

    /**
     * Set messageInsertDate
     *
     * @param string $messageInsertDate
     * @return Record
     */
    public function setMessageInsertDate($messageInsertDate)
    {
        $this->messageInsertDate = $messageInsertDate;
    
        return $this;
    }

    /**
     * Get messageInsertDate
     *
     * @return string 
     */
    public function getMessageInsertDate()
    {
        return $this->messageInsertDate;
    }

  

    /**
     * Set mOpeningHoursFrom
     *
     * @param string $mOpeningHoursFrom
     * @return Record
     */
    public function setMOpeningHoursFrom($mOpeningHoursFrom)
    {
        $this->mOpeningHoursFrom = $mOpeningHoursFrom;
    
        return $this;
    }

    /**
     * Get mOpeningHoursFrom
     *
     * @return string 
     */
    public function getMOpeningHoursFrom()
    {
        return $this->mOpeningHoursFrom;
    }

    /**
     * Set mOpeningHoursTo
     *
     * @param string $mOpeningHoursTo
     * @return Record
     */
    public function setMOpeningHoursTo($mOpeningHoursTo)
    {
        $this->mOpeningHoursTo = $mOpeningHoursTo;
    
        return $this;
    }

    /**
     * Get mOpeningHoursTo
     *
     * @return string 
     */
    public function getMOpeningHoursTo()
    {
        return $this->mOpeningHoursTo;
    }

    /**
     * Set aOpeningHoursFrom
     *
     * @param string $aOpeningHoursFrom
     * @return Record
     */
    public function setAOpeningHoursFrom($aOpeningHoursFrom)
    {
        $this->aOpeningHoursFrom = $aOpeningHoursFrom;
    
        return $this;
    }

    /**
     * Get aOpeningHoursFrom
     *
     * @return string 
     */
    public function getAOpeningHoursFrom()
    {
        return $this->aOpeningHoursFrom;
    }

    /**
     * Set aOpeningHoursTo
     *
     * @param string $aOpeningHoursTo
     * @return Record
     */
    public function setAOpeningHoursTo($aOpeningHoursTo)
    {
        $this->aOpeningHoursTo = $aOpeningHoursTo;
    
        return $this;
    }

    /**
     * Get aOpeningHoursTo
     *
     * @return string 
     */
    public function getAOpeningHoursTo()
    {
        return $this->aOpeningHoursTo;
    }

    /**
     * Set telNumberOne
     *
     * @param string $telNumberOne
     * @return Record
     */
    public function setTelNumberOne($telNumberOne)
    {
        $this->telNumberOne = $telNumberOne;
    
        return $this;
    }

    /**
     * Get telNumberOne
     *
     * @return string 
     */
    public function getTelNumberOne()
    {
        return $this->telNumberOne;
    }

    /**
     * Set telNumberTwo
     *
     * @param string $telNumberTwo
     * @return Record
     */
    public function setTelNumberTwo($telNumberTwo)
    {
        $this->telNumberTwo = $telNumberTwo;
    
        return $this;
    }

    /**
     * Get telNumberTwo
     *
     * @return string 
     */
    public function getTelNumberTwo()
    {
        return $this->telNumberTwo;
    }

    /**
     * Set telNumberThree
     *
     * @param string $telNumberThree
     * @return Record
     */
    public function setTelNumberThree($telNumberThree)
    {
        $this->telNumberThree = $telNumberThree;
    
        return $this;
    }

    /**
     * Get telNumberThree
     *
     * @return string 
     */
    public function getTelNumberThree()
    {
        return $this->telNumberThree;
    }

    /**
     * Set telNumberFour
     *
     * @param string $telNumberFour
     * @return Record
     */
    public function setTelNumberFour($telNumberFour)
    {
        $this->telNumberFour = $telNumberFour;
    
        return $this;
    }

    /**
     * Get telNumberFour
     *
     * @return string 
     */
    public function getTelNumberFour()
    {
        return $this->telNumberFour;
    }

    /**
     * Set faxNumberOne
     *
     * @param string $faxNumberOne
     * @return Record
     */
    public function setFaxNumberOne($faxNumberOne)
    {
        $this->faxNumberOne = $faxNumberOne;
    
        return $this;
    }

    /**
     * Get faxNumberOne
     *
     * @return string 
     */
    public function getFaxNumberOne()
    {
        return $this->faxNumberOne;
    }

    /**
     * Set faxNumberTwo
     *
     * @param string $faxNumberTwo
     * @return Record
     */
    public function setFaxNumberTwo($faxNumberTwo)
    {
        $this->faxNumberTwo = $faxNumberTwo;
    
        return $this;
    }

    /**
     * Get faxNumberTwo
     *
     * @return string 
     */
    public function getFaxNumberTwo()
    {
        return $this->faxNumberTwo;
    }

    /**
     * Set mobileNumberOne
     *
     * @param string $mobileNumberOne
     * @return Record
     */
    public function setMobileNumberOne($mobileNumberOne)
    {
        $this->mobileNumberOne = $mobileNumberOne;
    
        return $this;
    }

    /**
     * Get mobileNumberOne
     *
     * @return string 
     */
    public function getMobileNumberOne()
    {
        return $this->mobileNumberOne;
    }

    /**
     * Set mobileNumberTwo
     *
     * @param string $mobileNumberTwo
     * @return Record
     */
    public function setMobileNumberTwo($mobileNumberTwo)
    {
        $this->mobileNumberTwo = $mobileNumberTwo;
    
        return $this;
    }

    /**
     * Get mobileNumberTwo
     *
     * @return string 
     */
    public function getMobileNumberTwo()
    {
        return $this->mobileNumberTwo;
    }

    /**
     * Add images
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $images
     * @return Record
     */
    public function addImage(\Darkish\CategoryBundle\Entity\ManagedFile $images)
    {
        $this->images[] = $images;
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $images
     */
    public function removeImage(\Darkish\CategoryBundle\Entity\ManagedFile $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add videos
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $videos
     * @return Record
     */
    public function addVideo(\Darkish\CategoryBundle\Entity\ManagedFile $videos)
    {
        $this->videos[] = $videos;
    
        return $this;
    }

    /**
     * Remove videos
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $videos
     */
    public function removeVideo(\Darkish\CategoryBundle\Entity\ManagedFile $videos)
    {
        $this->videos->removeElement($videos);
    }

    /**
     * Get videos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVideos()
    {
        return $this->videos;
    }

    /**
     * Add audios
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $audios
     * @return Record
     */
    public function addAudio(\Darkish\CategoryBundle\Entity\ManagedFile $audios)
    {
        $this->audios[] = $audios;
    
        return $this;
    }

    /**
     * Remove audios
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $audios
     */
    public function removeAudio(\Darkish\CategoryBundle\Entity\ManagedFile $audios)
    {
        $this->audios->removeElement($audios);
    }

    /**
     * Get audios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAudios()
    {
        return $this->audios;
    }



    /**
     * Set body
     *
     * @param string $body
     * @return Record
     */
    public function setBody($body)
    {
        $this->body = $body;
    
        return $this;
    }

    /**
     * Get body
     *
     * @return string 
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Add bodyImages
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $bodyImages
     * @return Record
     */
    public function addBodyImage(\Darkish\CategoryBundle\Entity\ManagedFile $bodyImages)
    {
        $this->bodyImages[] = $bodyImages;
    
        return $this;
    }

    /**
     * Remove bodyImages
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $bodyImages
     */
    public function removeBodyImage(\Darkish\CategoryBundle\Entity\ManagedFile $bodyImages)
    {
        $this->bodyImages->removeElement($bodyImages);
    }

    /**
     * Get bodyImages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBodyImages()
    {
        return $this->bodyImages;
    }

    /**
     * Add bodyVideos
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $bodyVideos
     * @return Record
     */
    public function addBodyVideo(\Darkish\CategoryBundle\Entity\ManagedFile $bodyVideos)
    {
        $this->bodyVideos[] = $bodyVideos;
    
        return $this;
    }

    /**
     * Remove bodyVideos
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $bodyVideos
     */
    public function removeBodyVideo(\Darkish\CategoryBundle\Entity\ManagedFile $bodyVideos)
    {
        $this->bodyVideos->removeElement($bodyVideos);
    }

    /**
     * Get bodyVideos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBodyVideos()
    {
        return $this->bodyVideos;
    }

    /**
     * Add bodyAudios
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $bodyAudios
     * @return Record
     */
    public function addBodyAudio(\Darkish\CategoryBundle\Entity\ManagedFile $bodyAudios)
    {
        $this->bodyAudios[] = $bodyAudios;
    
        return $this;
    }

    /**
     * Remove bodyAudios
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $bodyAudios
     */
    public function removeBodyAudio(\Darkish\CategoryBundle\Entity\ManagedFile $bodyAudios)
    {
        $this->bodyAudios->removeElement($bodyAudios);
    }

    /**
     * Get bodyAudios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBodyAudios()
    {
        return $this->bodyAudios;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Record
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
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
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set lastUpdate
     *
     * @param \DateTime $lastUpdate
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
     * @return \DateTime 
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * Set englishTitle
     *
     * @param string $englishTitle
     * @return Record
     */
    public function setEnglishTitle($englishTitle)
    {
        $this->englishTitle = $englishTitle;
    
        return $this;
    }

    /**
     * Get englishTitle
     *
     * @return string 
     */
    public function getEnglishTitle()
    {
        return $this->englishTitle;
    }

    /**
     * Set englishSubTitle
     *
     * @param string $englishSubTitle
     * @return Record
     */
    public function setEnglishSubTitle($englishSubTitle)
    {
        $this->englishSubTitle = $englishSubTitle;
    
        return $this;
    }

    /**
     * Get englishSubTitle
     *
     * @return string 
     */
    public function getEnglishSubTitle()
    {
        return $this->englishSubTitle;
    }

    /**
     * Set arabicTitle
     *
     * @param string $arabicTitle
     * @return Record
     */
    public function setArabicTitle($arabicTitle)
    {
        $this->arabicTitle = $arabicTitle;
    
        return $this;
    }

    /**
     * Get arabicTitle
     *
     * @return string 
     */
    public function getArabicTitle()
    {
        return $this->arabicTitle;
    }

    /**
     * Set arabicSubTitle
     *
     * @param string $arabicSubTitle
     * @return Record
     */
    public function setArabicSubTitle($arabicSubTitle)
    {
        $this->arabicSubTitle = $arabicSubTitle;
    
        return $this;
    }

    /**
     * Get arabicSubTitle
     *
     * @return string 
     */
    public function getArabicSubTitle()
    {
        return $this->arabicSubTitle;
    }

    /**
     * Set turkishTitle
     *
     * @param string $turkishTitle
     * @return Record
     */
    public function setTurkishTitle($turkishTitle)
    {
        $this->turkishTitle = $turkishTitle;
    
        return $this;
    }

    /**
     * Get turkishTitle
     *
     * @return string 
     */
    public function getTurkishTitle()
    {
        return $this->turkishTitle;
    }

    /**
     * Set turkishSubTitle
     *
     * @param string $turkishSubTitle
     * @return Record
     */
    public function setTurkishSubTitle($turkishSubTitle)
    {
        $this->turkishSubTitle = $turkishSubTitle;
    
        return $this;
    }

    /**
     * Get turkishSubTitle
     *
     * @return string 
     */
    public function getTurkishSubTitle()
    {
        return $this->turkishSubTitle;
    }

    
    
    

    

    /**
     * Set icon
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $icon
     * @return Record
     */
    public function setIcon(\Darkish\CategoryBundle\Entity\ManagedFile $icon = null)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * Get icon
     *
     * @return \Darkish\CategoryBundle\Entity\ManagedFile 
     */
    public function getIcon()
    {
        if($this->icon) {
            return $this->icon;
        } elseif($this->images->count()) {
            return $this->images->first();
        } else {
            return $this->icon;
        }
    }

    /**
     * Set showContactOnList
     *
     * @param boolean $showContactOnList
     * @return Record
     */
    public function setShowContactOnList($showContactOnList)
    {
        $this->showContactOnList = $showContactOnList;

        return $this;
    }

    /**
     * Get showContactOnList
     *
     * @return boolean 
     */
    public function getShowContactOnList()
    {
        return $this->showContactOnList;
    }

    /**
     * Set onlyContactInformation
     *
     * @param boolean $onlyContactInformation
     * @return Record
     */
    public function setOnlyContactInformation($onlyContactInformation)
    {
        $this->onlyContactInformation = $onlyContactInformation;

        return $this;
    }

    /**
     * Get onlyContactInformation
     *
     * @return boolean 
     */
    public function getOnlyContactInformation()
    {
        return $this->onlyContactInformation;
    }

    /**
     * Add bodyDocs
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $bodyDocs
     * @return Record
     */
    public function addBodyDoc(\Darkish\CategoryBundle\Entity\ManagedFile $bodyDocs)
    {
        $this->bodyDocs[] = $bodyDocs;

        return $this;
    }

    /**
     * Remove bodyDocs
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $bodyDocs
     */
    public function removeBodyDoc(\Darkish\CategoryBundle\Entity\ManagedFile $bodyDocs)
    {
        $this->bodyDocs->removeElement($bodyDocs);
    }

    /**
     * Get bodyDocs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBodyDocs()
    {
        return $this->bodyDocs;
    }

    

    

    /**
     * Set user
     *
     * @param \Darkish\UserBundle\Entity\Operator $user
     * @return Record
     */
    public function setUser(\Darkish\UserBundle\Entity\Operator $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Darkish\UserBundle\Entity\Operator 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set infoOne
     *
     * @param string $infoOne
     * @return Record
     */
    public function setInfoOne($infoOne)
    {
        $this->infoOne = $infoOne;

        return $this;
    }

    /**
     * Get infoOne
     *
     * @return string 
     */
    public function getInfoOne()
    {
        return $this->infoOne;
    }

    /**
     * Set infoTwo
     *
     * @param string $infoTwo
     * @return Record
     */
    public function setInfoTwo($infoTwo)
    {
        $this->infoTwo = $infoTwo;

        return $this;
    }

    /**
     * Get infoTwo
     *
     * @return string 
     */
    public function getInfoTwo()
    {
        return $this->infoTwo;
    }

    /**
     * Set hostelry
     *
     * @param boolean $hostelry
     * @return Record
     */
    public function setHostelry($hostelry)
    {
        $this->hostelry = $hostelry;

        return $this;
    }

    /**
     * Get hostelry
     *
     * @return boolean 
     */
    public function getHostelry()
    {
        return $this->hostelry;
    }

    /**
     * Set htmlLastUpdate
     *
     * @param \DateTime $htmlLastUpdate
     * @return Record
     */
    public function setHtmlLastUpdate($htmlLastUpdate)
    {
        $this->htmlLastUpdate = $htmlLastUpdate;

        return $this;
    }

    /**
     * Get htmlLastUpdate
     *
     * @return \DateTime 
     */
    public function getHtmlLastUpdate()
    {
        return $this->htmlLastUpdate;
    }

    /**
     * Set listRankTwo
     *
     * @param integer $listRankTwo
     * @return Record
     */
    public function setListRankTwo($listRankTwo)
    {
        $this->listRankTwo = $listRankTwo;

        return $this;
    }

    /**
     * Get listRankTwo
     *
     * @return integer 
     */
    public function getListRankTwo()
    {
        return $this->listRankTwo;
    }

    /**
     * Set listRankThree
     *
     * @param integer $listRankThree
     * @return Record
     */
    public function setListRankThree($listRankThree)
    {
        $this->listRankThree = $listRankThree;

        return $this;
    }

    /**
     * Get listRankThree
     *
     * @return integer 
     */
    public function getListRankThree()
    {
        return $this->listRankThree;
    }

    /**
     * Set listRankFour
     *
     * @param integer $listRankFour
     * @return Record
     */
    public function setListRankFour($listRankFour)
    {
        $this->listRankFour = $listRankFour;

        return $this;
    }

    /**
     * Get listRankFour
     *
     * @return integer 
     */
    public function getListRankFour()
    {
        return $this->listRankFour;
    }

    /**
     * Set listRankFive
     *
     * @param integer $listRankFive
     * @return Record
     */
    public function setListRankFive($listRankFive)
    {
        $this->listRankFive = $listRankFive;

        return $this;
    }

    /**
     * Get listRankFive
     *
     * @return integer 
     */
    public function getListRankFive()
    {
        return $this->listRankFive;
    }

    /**
     * Set archive
     *
     * @param boolean $archive
     * @return Record
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * Get archive
     *
     * @return boolean 
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * Set smsNumber
     *
     * @param string $smsNumber
     * @return Record
     */
    public function setSmsNumber($smsNumber)
    {
        $this->smsNumber = $smsNumber;

        return $this;
    }

    /**
     * Get smsNumber
     *
     * @return string 
     */
    public function getSmsNumber()
    {
        return $this->smsNumber;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     * @return Record
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string 
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set sellServicePageTitle
     *
     * @param string $sellServicePageTitle
     * @return Record
     */
    public function setSellServicePageTitle($sellServicePageTitle)
    {
        $this->sellServicePageTitle = $sellServicePageTitle;

        return $this;
    }

    /**
     * Get sellServicePageTitle
     *
     * @return string 
     */
    public function getSellServicePageTitle()
    {
        return $this->sellServicePageTitle;
    }

    /**
     * Set sellServicePage
     *
     * @param boolean $sellServicePage
     * @return Record
     */
    public function setSellServicePage($sellServicePage)
    {
        $this->sellServicePage = $sellServicePage;

        return $this;
    }

    /**
     * Get sellServicePage
     *
     * @return boolean 
     */
    public function getSellServicePage()
    {
        return $this->sellServicePage;
    }

    /**
     * Add customers
     *
     * @param \Darkish\CustomerBundle\Entity\Customer $customers
     * @return Record
     */
    public function addCustomer(\Darkish\CustomerBundle\Entity\Customer $customers)
    {
        $this->customers[] = $customers;

        return $this;
    }

    /**
     * Remove customers
     *
     * @param \Darkish\CustomerBundle\Entity\Customer $customers
     */
    public function removeCustomer(\Darkish\CustomerBundle\Entity\Customer $customers)
    {
        $this->customers->removeElement($customers);
    }

    /**
     * Get customers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCustomers()
    {
        return $this->customers;
    }

    /**
     * Add maintrees
     *
     * @param \Darkish\CategoryBundle\Entity\RecordMainTree $maintrees
     * @return Record
     */
    public function addMaintree(\Darkish\CategoryBundle\Entity\RecordMainTree $maintrees)
    {
        $this->maintrees[] = $maintrees;

        return $this;
    }

    /**
     * Remove maintrees
     *
     * @param \Darkish\CategoryBundle\Entity\RecordMainTree $maintrees
     */
    public function removeMaintree(\Darkish\CategoryBundle\Entity\RecordMainTree $maintrees)
    {
        $this->maintrees->removeElement($maintrees);
    }

    /**
     * Get maintrees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMaintrees()
    {
        return $this->maintrees;
    }

    /**
     * Set thread
     *
     * @param \Darkish\CommentBundle\Entity\RecordThread $thread
     * @return Record
     */
    public function setThread(\Darkish\CommentBundle\Entity\RecordThread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Darkish\CommentBundle\Entity\RecordThread 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set commentDefaultState
     *
     * @param boolean $commentDefaultState
     * @return Record
     */
    public function setCommentDefaultState($commentDefaultState)
    {
        $this->commentDefaultState = $commentDefaultState;

        return $this;
    }

    /**
     * Get commentDefaultState
     *
     * @return boolean 
     */
    public function getCommentDefaultState()
    {
        return $this->commentDefaultState;
    }

    /**
     * Set commentable
     *
     * @param boolean $commentable
     * @return Record
     */
    public function setCommentable($commentable)
    {
        $this->commentable = $commentable;

        return $this;
    }

    /**
     * Get commentable
     *
     * @return boolean 
     */
    public function getCommentable()
    {
        return $this->commentable;
    }

    /**
     * Set accessClass
     *
     * @param \Darkish\CategoryBundle\Entity\RecordAccessLevel $accessClass
     * @return Record
     */
    public function setAccessClass(\Darkish\CategoryBundle\Entity\RecordAccessLevel $accessClass = null)
    {
        $this->accessClass = $accessClass;

        return $this;
    }

    /**
     * Get accessClass
     *
     * @return \Darkish\CategoryBundle\Entity\RecordAccessLevel 
     */
    public function getAccessClass()
    {
        return $this->accessClass;
    }

    /**
     * Add clientsFavorited
     *
     * @param \Darkish\UserBundle\Entity\Client $clientsFavorited
     * @return Record
     */
    public function addClientsFavorited(\Darkish\UserBundle\Entity\Client $clientsFavorited)
    {
        $this->clientsFavorited[] = $clientsFavorited;

        return $this;
    }

    /**
     * Remove clientsFavorited
     *
     * @param \Darkish\UserBundle\Entity\Client $clientsFavorited
     */
    public function removeClientsFavorited(\Darkish\UserBundle\Entity\Client $clientsFavorited)
    {
        $this->clientsFavorited->removeElement($clientsFavorited);
    }

    /**
     * Get clientsFavorited
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClientsFavorited()
    {
        return $this->clientsFavorited;
    }



    /**
     * Add messageThreads
     *
     * @param \Darkish\CategoryBundle\Entity\MessageThread $messageThreads
     * @return MessageThread
     */
    public function addMessageThread(\Darkish\CategoryBundle\Entity\MessageThread $messageThreads)
    {
        $this->messageThreads[] = $messageThreads;

        return $this;
    }

    /**
     * Remove messageThreads
     *
     * @param \Darkish\CategoryBundle\Entity\MessageThread $messageThreads
     */
    public function removeMessageThread(\Darkish\CategoryBundle\Entity\MessageThread $messageThreads)
    {
        $this->messageThreads->removeElement($messageThreads);
    }

    /**
     * Get messageThreads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMessageThreads()
    {
        return $this->messageThreads;
    }

    /**
     * Set lastMessageRecieve
     *
     * @param integer $lastMessageRecieve
     * @return Record
     */
    public function setLastMessageRecieve($lastMessageRecieve)
    {
        $this->lastMessageRecieve = $lastMessageRecieve;

        return $this;
    }

    /**
     * Get lastMessageRecieve
     *
     * @return integer 
     */
    public function getLastMessageRecieve()
    {
        return $this->lastMessageRecieve;
    }

    /**
     * Set marketDescription
     *
     * @param string $marketDescription
     * @return Record
     */
    public function setMarketDescription($marketDescription)
    {
        $this->marketDescription = $marketDescription;

        return $this;
    }

    /**
     * Get marketDescription
     *
     * @return string 
     */
    public function getMarketDescription()
    {
        return $this->marketDescription;
    }

    /**
     * Set marketBanner
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $marketBanner
     * @return Record
     */
    public function setMarketBanner(\Darkish\CategoryBundle\Entity\ManagedFile $marketBanner = null)
    {
        $this->marketBanner = $marketBanner;

        return $this;
    }

    /**
     * Get marketBanner
     *
     * @return \Darkish\CategoryBundle\Entity\ManagedFile 
     */
    public function getMarketBanner()
    {
        return $this->marketBanner;
    }

    /**
     * Set marketTemplate
     *
     * @param \Darkish\CategoryBundle\Entity\Template $marketTemplate
     * @return Record
     */
    public function setMarketTemplate(\Darkish\CategoryBundle\Entity\Template $marketTemplate = null)
    {
        $this->marketTemplate = $marketTemplate;

        return $this;
    }

    /**
     * Get marketTemplate
     *
     * @return \Darkish\CategoryBundle\Entity\Template 
     */
    public function getMarketTemplate()
    {
        return $this->marketTemplate;
    }

    /**
     * Add marketGroups
     *
     * @param \Darkish\CategoryBundle\Entity\StoreGroup $marketGroups
     * @return Record
     */
    public function addMarketGroup(\Darkish\CategoryBundle\Entity\StoreGroup $marketGroups)
    {
        $this->marketGroups[] = $marketGroups;

        return $this;
    }

    /**
     * Remove marketGroups
     *
     * @param \Darkish\CategoryBundle\Entity\StoreGroup $marketGroups
     */
    public function removeMarketGroup(\Darkish\CategoryBundle\Entity\StoreGroup $marketGroups)
    {
        $this->marketGroups->removeElement($marketGroups);
    }

    /**
     * Get marketGroups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMarketGroups()
    {
        return $this->marketGroups;
    }



    /**
     * Set marketOnlineOrder
     *
     * @param integer $marketOnlineOrder
     * @return Record
     */
    public function setMarketOnlineOrder($marketOnlineOrder)
    {
        $this->marketOnlineOrder = $marketOnlineOrder;

        return $this;
    }

    /**
     * Get marketOnlineOrder
     *
     * @return integer 
     */
    public function getMarketOnlineOrder()
    {
        return $this->marketOnlineOrder;
    }

    /**
     * Set dbaseDescription
     *
     * @param string $dbaseDescription
     * @return Record
     */
    public function setDbaseDescription($dbaseDescription)
    {
        $this->dbaseDescription = $dbaseDescription;

        return $this;
    }

    /**
     * Get dbaseDescription
     *
     * @return string 
     */
    public function getDbaseDescription()
    {
        return $this->dbaseDescription;
    }

    /**
     * Set dbaseBanner
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $dbaseBanner
     * @return Record
     */
    public function setDbaseBanner(\Darkish\CategoryBundle\Entity\ManagedFile $dbaseBanner = null)
    {
        $this->dbaseBanner = $dbaseBanner;

        return $this;
    }

    /**
     * Get dbaseBanner
     *
     * @return \Darkish\CategoryBundle\Entity\ManagedFile 
     */
    public function getDbaseBanner()
    {
        return $this->dbaseBanner;
    }

    /**
     * Set nonSearchable
     *
     * @param boolean $nonSearchable
     * @return Record
     */
    public function setNonSearchable($nonSearchable)
    {
        $this->nonSearchable = $nonSearchable;

        return $this;
    }

    /**
     * Get nonSearchable
     *
     * @return boolean 
     */
    public function getNonSearchable()
    {
        return $this->nonSearchable;
    }

    /**
     * Set commentCount
     *
     * @param integer $commentCount
     * @return Record
     */
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;

        return $this;
    }

    /**
     * Get commentCount
     *
     * @return integer 
     */
    public function getCommentCount()
    {
        return $this->commentCount;
    }

    /**
     * Set ticketSeller
     *
     * @param boolean $ticketSeller
     *
     * @return Record
     */
    public function setTicketSeller($ticketSeller)
    {
        $this->ticketSeller = $ticketSeller;

        return $this;
    }

    /**
     * Get ticketSeller
     *
     * @return boolean
     */
    public function getTicketSeller()
    {
        return $this->ticketSeller;
    }

    /**
     * Set ticketSellerSort
     *
     * @param integer $ticketSellerSort
     *
     * @return Record
     */
    public function setTicketSellerSort($ticketSellerSort)
    {
        $this->ticketSellerSort = $ticketSellerSort;

        return $this;
    }

    /**
     * Get ticketSellerSort
     *
     * @return integer
     */
    public function getTicketSellerSort()
    {
        return $this->ticketSellerSort;
    }

    /**
     * Set ticketServer
     *
     * @param boolean $ticketServer
     *
     * @return Record
     */
    public function setTicketServer($ticketServer)
    {
        $this->ticketServer = $ticketServer;

        return $this;
    }

    /**
     * Get ticketServer
     *
     * @return boolean
     */
    public function getTicketServer()
    {
        return $this->ticketServer;
    }

    /**
     * Set ticketServerTreeSort
     *
     * @param integer $ticketServerTreeSort
     *
     * @return Record
     */
    public function setTicketServerTreeSort($ticketServerTreeSort)
    {
        $this->ticketServerTreeSort = $ticketServerTreeSort;

        return $this;
    }

    /**
     * Get ticketServerTreeSort
     *
     * @return integer
     */
    public function getTicketServerTreeSort()
    {
        return $this->ticketServerTreeSort;
    }

    /**
     * Set ticketServerTree
     *
     * @param \Darkish\CategoryBundle\Entity\TicketServerTree $ticketServerTree
     *
     * @return Record
     */
    public function setTicketServerTree(\Darkish\CategoryBundle\Entity\TicketServerTree $ticketServerTree = null)
    {
        $this->ticketServerTree = $ticketServerTree;

        return $this;
    }

    /**
     * Get ticketServerTree
     *
     * @return \Darkish\CategoryBundle\Entity\TicketServerTree
     */
    public function getTicketServerTree()
    {
        return $this->ticketServerTree;
    }

    /**
     * Set customerRegisterUsed
     *
     * @param boolean $customerRegisterUsed
     *
     * @return Record
     */
    public function setCustomerRegisterUsed($customerRegisterUsed)
    {
        $this->customerRegisterUsed = $customerRegisterUsed;

        return $this;
    }

    /**
     * Get customerRegisterUsed
     *
     * @return boolean
     */
    public function getCustomerRegisterUsed()
    {
        return $this->customerRegisterUsed;
    }

    /**
     * Set treeJson
     *
     * @param array $treeJson
     *
     * @return Record
     */
    public function setTreeJson($treeJson)
    {
        $this->treeJson = $treeJson;

        return $this;
    }

    /**
     * Get treeJson
     *
     * @return array
     */
    public function getTreeJson()
    {
        return $this->treeJson;
    }

    /**
     * Set lastGroupMessage
     *
     * @param \DateTime $lastGroupMessage
     *
     * @return Record
     */
    public function setLastGroupMessage($lastGroupMessage)
    {
        $this->lastGroupMessage = $lastGroupMessage;

        return $this;
    }

    /**
     * Get lastGroupMessage
     *
     * @return \DateTime
     */
    public function getLastGroupMessage()
    {
        return $this->lastGroupMessage;
    }

    /**
     * Set ownerPhone
     *
     * @param string $ownerPhone
     *
     * @return Record
     */
    public function setOwnerPhone($ownerPhone)
    {
        $this->ownerPhone = $ownerPhone;

        return $this;
    }

    /**
     * Get ownerPhone
     *
     * @return string
     */
    public function getOwnerPhone()
    {
        return $this->ownerPhone;
    }

    /**
     * Set manager
     *
     * @param string $manager
     *
     * @return Record
     */
    public function setManager($manager)
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * Get manager
     *
     * @return string
     */
    public function getManager()
    {
        return $this->manager;
    }

    /**
     * Set managerPhone
     *
     * @param string $managerPhone
     *
     * @return Record
     */
    public function setManagerPhone($managerPhone)
    {
        $this->managerPhone = $managerPhone;

        return $this;
    }

    /**
     * Get managerPhone
     *
     * @return string
     */
    public function getManagerPhone()
    {
        return $this->managerPhone;
    }

    /**
     * Set ownerMail
     *
     * @param string $ownerMail
     *
     * @return Record
     */
    public function setOwnerMail($ownerMail)
    {
        $this->ownerMail = $ownerMail;

        return $this;
    }

    /**
     * Get ownerMail
     *
     * @return string
     */
    public function getOwnerMail()
    {
        return $this->ownerMail;
    }

    /**
     * Set managerMail
     *
     * @param string $managerMail
     *
     * @return Record
     */
    public function setManagerMail($managerMail)
    {
        $this->managerMail = $managerMail;

        return $this;
    }

    /**
     * Get managerMail
     *
     * @return string
     */
    public function getManagerMail()
    {
        return $this->managerMail;
    }

    /**
     * Set latLongEncoded
     *
     * @param string $latLongEncoded
     *
     * @return Record
     */
    public function setLatLongEncoded($latLongEncoded)
    {
        $this->latLongEncoded = $latLongEncoded;

        return $this;
    }

    /**
     * Get latLongEncoded
     *
     * @return string
     */
    public function getLatLongEncoded()
    {
        return $this->latLongEncoded;
    }

    /**
     * Set marketLastUpdate
     *
     * @param \DateTime $marketLastUpdate
     *
     * @return Record
     */
    public function setMarketLastUpdate($marketLastUpdate)
    {
        $this->marketLastUpdate = $marketLastUpdate;

        return $this;
    }

    /**
     * Get marketLastUpdate
     *
     * @return \DateTime
     */
    public function getMarketLastUpdate()
    {
        return $this->marketLastUpdate;
    }

    /**
     * Set marketLastCacheCreate
     *
     * @param \DateTime $marketLastCacheCreate
     *
     * @return Record
     */
    public function setMarketLastCacheCreate($marketLastCacheCreate)
    {
        $this->marketLastCacheCreate = $marketLastCacheCreate;

        return $this;
    }

    /**
     * Get marketLastCacheCreate
     *
     * @return \DateTime
     */
    public function getMarketLastCacheCreate()
    {
        return $this->marketLastCacheCreate;
    }

    /**
     * Set telNumberOneLabel
     *
     * @param string $telNumberOneLabel
     *
     * @return Record
     */
    public function setTelNumberOneLabel($telNumberOneLabel)
    {
        $this->telNumberOneLabel = $telNumberOneLabel;

        return $this;
    }

    /**
     * Get telNumberOneLabel
     *
     * @return string
     */
    public function getTelNumberOneLabel()
    {
        return $this->telNumberOneLabel;
    }

    /**
     * Set telNumberTwoLabel
     *
     * @param string $telNumberTwoLabel
     *
     * @return Record
     */
    public function setTelNumberTwoLabel($telNumberTwoLabel)
    {
        $this->telNumberTwoLabel = $telNumberTwoLabel;

        return $this;
    }

    /**
     * Get telNumberTwoLabel
     *
     * @return string
     */
    public function getTelNumberTwoLabel()
    {
        return $this->telNumberTwoLabel;
    }

    /**
     * Set telNumberThreeLabel
     *
     * @param string $telNumberThreeLabel
     *
     * @return Record
     */
    public function setTelNumberThreeLabel($telNumberThreeLabel)
    {
        $this->telNumberThreeLabel = $telNumberThreeLabel;

        return $this;
    }

    /**
     * Get telNumberThreeLabel
     *
     * @return string
     */
    public function getTelNumberThreeLabel()
    {
        return $this->telNumberThreeLabel;
    }

    /**
     * Set telNumberFourLabel
     *
     * @param string $telNumberFourLabel
     *
     * @return Record
     */
    public function setTelNumberFourLabel($telNumberFourLabel)
    {
        $this->telNumberFourLabel = $telNumberFourLabel;

        return $this;
    }

    /**
     * Get telNumberFourLabel
     *
     * @return string
     */
    public function getTelNumberFourLabel()
    {
        return $this->telNumberFourLabel;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Record
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set expireDate
     *
     * @param \DateTime $expireDate
     *
     * @return Record
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    /**
     * Get expireDate
     *
     * @return \DateTime
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * Set sellServicePageCustomer
     *
     * @param boolean $sellServicePageCustomer
     *
     * @return Record
     */
    public function setSellServicePageCustomer($sellServicePageCustomer)
    {
        $this->sellServicePageCustomer = $sellServicePageCustomer;

        return $this;
    }

    /**
     * Get sellServicePageCustomer
     *
     * @return boolean
     */
    public function getSellServicePageCustomer()
    {
        return $this->sellServicePageCustomer;
    }

    /**
     * Set dbaseEnableCustomer
     *
     * @param boolean $dbaseEnableCustomer
     *
     * @return Record
     */
    public function setDbaseEnableCustomer($dbaseEnableCustomer)
    {
        $this->dbaseEnableCustomer = $dbaseEnableCustomer;

        return $this;
    }

    /**
     * Get dbaseEnableCustomer
     *
     * @return boolean
     */
    public function getDbaseEnableCustomer()
    {
        return $this->dbaseEnableCustomer;
    }

    /**
     * Set commentableCustomer
     *
     * @param boolean $commentableCustomer
     *
     * @return Record
     */
    public function setCommentableCustomer($commentableCustomer)
    {
        $this->commentableCustomer = $commentableCustomer;

        return $this;
    }

    /**
     * Get commentableCustomer
     *
     * @return boolean
     */
    public function getCommentableCustomer()
    {
        return $this->commentableCustomer;
    }

    /**
     * Set storeCache
     *
     * @param \Darkish\CategoryBundle\Entity\Cache\StoreCache $storeCache
     *
     * @return Record
     */
    public function setStoreCache(\Darkish\CategoryBundle\Entity\Cache\StoreCache $storeCache = null)
    {
        $this->storeCache = $storeCache;

        return $this;
    }

    /**
     * Get storeCache
     *
     * @return \Darkish\CategoryBundle\Entity\Cache\StoreCache
     */
    public function getStoreCache()
    {
        return $this->storeCache;
    }

    /**
     * Add product
     *
     * @param \Darkish\CategoryBundle\Entity\Product $product
     *
     * @return Record
     */
    public function addProduct(\Darkish\CategoryBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \Darkish\CategoryBundle\Entity\Product $product
     */
    public function removeProduct(\Darkish\CategoryBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Add dbaseItem
     *
     * @param \Darkish\CategoryBundle\Entity\DBase $dbaseItem
     *
     * @return Record
     */
    public function addDbaseItem(\Darkish\CategoryBundle\Entity\DBase $dbaseItem)
    {
        $this->dbaseItems[] = $dbaseItem;

        return $this;
    }

    /**
     * Remove dbaseItem
     *
     * @param \Darkish\CategoryBundle\Entity\DBase $dbaseItem
     */
    public function removeDbaseItem(\Darkish\CategoryBundle\Entity\DBase $dbaseItem)
    {
        $this->dbaseItems->removeElement($dbaseItem);
    }

    /**
     * Get dbaseItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDbaseItems()
    {
        return $this->dbaseItems;
    }

    /**
     * Set openingHoursDesc
     *
     * @param string $openingHoursDesc
     *
     * @return Record
     */
    public function setOpeningHoursDesc($openingHoursDesc)
    {
        $this->openingHoursDesc = $openingHoursDesc;

        return $this;
    }

    /**
     * Get openingHoursDesc
     *
     * @return string
     */
    public function getOpeningHoursDesc()
    {
        return $this->openingHoursDesc;
    }

    /**
     * Set workingDaysDesc
     *
     * @param string $workingDaysDesc
     *
     * @return Record
     */
    public function setWorkingDaysDesc($workingDaysDesc)
    {
        $this->workingDaysDesc = $workingDaysDesc;

        return $this;
    }

    /**
     * Get workingDaysDesc
     *
     * @return string
     */
    public function getWorkingDaysDesc()
    {
        return $this->workingDaysDesc;
    }



    /**
     * Set messageValidityDate
     *
     * @param string $messageValidityDate
     *
     * @return Record
     */
    public function setMessageValidityDate($messageValidityDate)
    {
        $this->messageValidityDate = $messageValidityDate;

        return $this;
    }

    /**
     * Get messageValidityDate
     *
     * @return string
     */
    public function getMessageValidityDate()
    {
        return $this->messageValidityDate;
    }

    /**
     * Set isCheckedFiles
     *
     * @param boolean $isCheckedFiles
     *
     * @return Record
     */
    public function setIsCheckedFiles($isCheckedFiles)
    {
        $this->isCheckedFiles = $isCheckedFiles;

        return $this;
    }

    /**
     * Get isCheckedFiles
     *
     * @return boolean
     */
    public function getIsCheckedFiles()
    {
        return $this->isCheckedFiles;
    }

    /**
     * Set dbaseTypeIndex
     *
     * @param \Darkish\CategoryBundle\Entity\DbaseType $dbaseTypeIndex
     *
     * @return Record
     */
    public function setDbaseTypeIndex(\Darkish\CategoryBundle\Entity\DbaseType $dbaseTypeIndex = null)
    {
        $this->dbaseTypeIndex = $dbaseTypeIndex;

        return $this;
    }

    /**
     * Get dbaseTypeIndex
     *
     * @return \Darkish\CategoryBundle\Entity\DbaseType
     */
    public function getDbaseTypeIndex()
    {
        return $this->dbaseTypeIndex;
    }

    /**
     * Set webBody
     *
     * @param string $webBody
     *
     * @return Record
     */
    public function setWebBody($webBody)
    {
        $this->webBody = $webBody;

        return $this;
    }

    /**
     * Get webBody
     *
     * @return string
     */
    public function getWebBody()
    {
        return $this->webBody;
    }

    /**
     * Set disableRecommendation
     *
     * @param boolean $disableRecommendation
     *
     * @return Record
     */
    public function setDisableRecommendation($disableRecommendation)
    {
        $this->disableRecommendation = $disableRecommendation;

        return $this;
    }

    /**
     * Get disableRecommendation
     *
     * @return boolean
     */
    public function getDisableRecommendation()
    {
        return $this->disableRecommendation;
    }

    /**
     * Set telNumberFive
     *
     * @param string $telNumberFive
     *
     * @return Record
     */
    public function setTelNumberFive($telNumberFive)
    {
        $this->telNumberFive = $telNumberFive;

        return $this;
    }

    /**
     * Get telNumberFive
     *
     * @return string
     */
    public function getTelNumberFive()
    {
        return $this->telNumberFive;
    }

    /**
     * Set telNumberFiveLabel
     *
     * @param string $telNumberFiveLabel
     *
     * @return Record
     */
    public function setTelNumberFiveLabel($telNumberFiveLabel)
    {
        $this->telNumberFiveLabel = $telNumberFiveLabel;

        return $this;
    }

    /**
     * Get telNumberFiveLabel
     *
     * @return string
     */
    public function getTelNumberFiveLabel()
    {
        return $this->telNumberFiveLabel;
    }

    /**
     * Set telNumberSix
     *
     * @param string $telNumberSix
     *
     * @return Record
     */
    public function setTelNumberSix($telNumberSix)
    {
        $this->telNumberSix = $telNumberSix;

        return $this;
    }

    /**
     * Get telNumberSix
     *
     * @return string
     */
    public function getTelNumberSix()
    {
        return $this->telNumberSix;
    }

    /**
     * Set telNumberSixLabel
     *
     * @param string $telNumberSixLabel
     *
     * @return Record
     */
    public function setTelNumberSixLabel($telNumberSixLabel)
    {
        $this->telNumberSixLabel = $telNumberSixLabel;

        return $this;
    }

    /**
     * Get telNumberSixLabel
     *
     * @return string
     */
    public function getTelNumberSixLabel()
    {
        return $this->telNumberSixLabel;
    }

    /**
     * Set telNumberSeven
     *
     * @param string $telNumberSeven
     *
     * @return Record
     */
    public function setTelNumberSeven($telNumberSeven)
    {
        $this->telNumberSeven = $telNumberSeven;

        return $this;
    }

    /**
     * Get telNumberSeven
     *
     * @return string
     */
    public function getTelNumberSeven()
    {
        return $this->telNumberSeven;
    }

    /**
     * Set telNumberSevenLabel
     *
     * @param string $telNumberSevenLabel
     *
     * @return Record
     */
    public function setTelNumberSevenLabel($telNumberSevenLabel)
    {
        $this->telNumberSevenLabel = $telNumberSevenLabel;

        return $this;
    }

    /**
     * Get telNumberSevenLabel
     *
     * @return string
     */
    public function getTelNumberSevenLabel()
    {
        return $this->telNumberSevenLabel;
    }

    /**
     * Set telNumberEight
     *
     * @param string $telNumberEight
     *
     * @return Record
     */
    public function setTelNumberEight($telNumberEight)
    {
        $this->telNumberEight = $telNumberEight;

        return $this;
    }

    /**
     * Get telNumberEight
     *
     * @return string
     */
    public function getTelNumberEight()
    {
        return $this->telNumberEight;
    }

    /**
     * Set telNumberEightLabel
     *
     * @param string $telNumberEightLabel
     *
     * @return Record
     */
    public function setTelNumberEightLabel($telNumberEightLabel)
    {
        $this->telNumberEightLabel = $telNumberEightLabel;

        return $this;
    }

    /**
     * Get telNumberEightLabel
     *
     * @return string
     */
    public function getTelNumberEightLabel()
    {
        return $this->telNumberEightLabel;
    }
}
