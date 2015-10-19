<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile as UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;


/**
 * ManagedFile
 *
 * @ORM\Table(name = "files")
 * @ORM\Entity
 */
class ManagedFile
{

    public static $uploadDirectories = [
        "image",
//        "video",
//        "audio",
//        "icon",
//        "doc",
//        "banner"
    ];

    /**
     *
     */
    private $file;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     *
     *
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255)
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "api.list"})
     */
    private $fileName;

    /**
     * @ORM\Column(name="title", type="string", nullable=true)
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "api.list"})
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="filemime", type="string", length=255)
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     */
    private $filemime;

    /**
     * @var string
     *
     * @ORM\Column(name="filesize", type="string", length=255)
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     */
    private $filesize;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     *
     */
    private $status;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="continual", type="boolean", nullable=true, options={"default":0})
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     *
     */
    private $continual;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_thumbnail", type="boolean", nullable=true, options={"default":0})
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     *
     */
    private $isThumbnail;
    
    /**
     *
     * @var string 
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details", "message.list", "message.details"})
     */
    private $webAbsolutePath;

    /**
     *
     * @var string 
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details", "message.list", "message.details"})
     */
    private $mobileAbsolutePath;

    /**
     * @var boolean
     * @ORM\Column(name="darkish_watermark", type="boolean", options={"default"=false})
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details", "message.list", "message.details"})
     */
    private $darkishWatermark = false;

    /**
     * @var boolean
     * @ORM\Column(name="island_watermark", type="boolean", options={"default"=false})
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details", "message.list", "message.details"})
     */
    private $islandWatermark = false;

    /**
     * @var boolean
     * @ORM\Column(name="aruna_watermark", type="boolean", options={"default"=false})
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details", "message.list", "message.details"})
     */
    private $arunaWatermark = false;

    /**
     * @var boolean
     * @ORM\Column(name="label_watermark", type="boolean", options={"default"=false})
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details", "message.list", "message.details"})
     */
    private $labelWatermark = false;

    /**
     * @var boolean
     * @ORM\Column(name="cheched", type="boolean", options={"default"=false})
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details", "message.list", "message.details"})
     */
    private $checked = false;

    /**
     *
     * @var string 
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details", "message.list", "message.details", "api.list"})
     */
    private $iconAbsolutePath;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetimetz")
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="video_thumbnail", type="string", length=255, nullable=true)
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "api.list"})
     */
    private $videoThumbnail;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     *
     * @Assert\Choice(choices = {"news", "classified", "offer", "sponsor", "record", "operator", "customer", "client", "store", "product", "database", "comment", "itinerary"}, message = "input a valid entity type.")
     *
     *
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="entity_id", type = "integer", nullable=true)
     *
     *
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     */
    private $entityId;


    /**
     * @var string
     *
     * @ORM\Column(name="upload_dir", type="string", nullable=true)
     *
     * @Assert\Choice(choices = {"image", "video", "audio", "icon", "doc", "banner"}, message = "Input a valid uploadDir.")
     *
     *
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     */
    private $uploadDir;

    /**
     * @ORM\ManyToMany(targetEntity="Record", mappedBy="bodyImages")
     */
    private $recordAsBodyImage;

    /**
     * @ORM\ManyToMany(targetEntity="News", mappedBy="bodyImages")
     */
    private $newsAsBodyImage;

    /**
     * @var string
     *
     * @ORM\Column(name="upload_key", type="string", nullable=true)
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details"})
     * 
     */
    private $uploadKey;
    
    /**
     * @ORM\OneToMany(targetEntity="Record", mappedBy="icon")
     * @Groups({"file.details"})
     */
    protected $iconForRecord;
    
    /**
     * @ORM\OneToMany(targetEntity="News", mappedBy="icon")
     * @Groups({"file.details"})
     */
    protected $iconForNews;

    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="icon")
     * @Groups({"file.details"})
     */
    protected $iconForOffer;

    /**
     * @ORM\OneToMany(targetEntity="Sponsor", mappedBy="icon")
     * @Groups({"file.details"})
     */
    protected $iconForSponsor;
    
    protected $oneup = false;

    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="banner")
     * @Groups({"file.details"})
     */
    protected $bannerForOffer;

    /**
     * @ORM\OneToMany(targetEntity="Sponsor", mappedBy="banner")
     * @Groups({"file.details"})
     */
    protected $bannerForSponsor;
    
    /**
     * @ORM\OneToMany(targetEntity="Classified", mappedBy="icon")
     * @Groups({"file.details"})
     */
    protected $iconForClassified;
    
    /**
     * @ORM\OneToMany(targetEntity="Record", mappedBy="marketBanner")
     */
    protected $recordForMarketBanner;

    /**
     * @ORM\OneToMany(targetEntity="Record", mappedBy="dbaseBanner")
     */
    protected $recordForDbaseBanner;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }


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
     * Set userId
     *
     * @param integer $userId
     * @return ManagedFile
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer 
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     * @return ManagedFile
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string 
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return ManagedFile
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

    public function setWebAbsolutePath($path) {
        $this->webAbsolutePath = $path;
        
        return $this;
    }
    
    
    /**
     * 
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details"})
     * @VirtualProperty
     * @SerializedName("absolute_path")
     */
    public function getWebAbsolutePath() { 
        return $this->webAbsolutePath;
    }


    public function setMobileAbsolutePath($path) {
        $this->mobileAbsolutePath = $path;
        
        return $this;
    }
    
    
    /**
     * 
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details", "message.list", "message.details"})
     * @VirtualProperty
     * @SerializedName("absolute_path")
     */
    public function getMobileAbsolutePath() { 
        return $this->mobileAbsolutePath;
    }


    public function setIconAbsolutePath($path) {
        $this->iconAbsolutePath = $path;
        
        return $this;
    }
    
    
    /**
     * 
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "comment.details", "message.list", "message.details"})
     * @VirtualProperty
     * @SerializedName("absolute_path")
     */
    public function getIconAbsolutePath() { 
        return $this->iconAbsolutePath;
    }
    
    /**
     * Set filemime
     *
     * @param string $filemime
     * @return ManagedFile
     */
    public function setFilemime($filemime)
    {
        $this->filemime = $filemime;

        return $this;
    }

    /**
     * Get filemime
     *
     * @return string 
     */
    public function getFilemime()
    {
        return $this->filemime;
    }

    /**
     * Set filesize
     *
     * @param string $filesize
     * @return ManagedFile
     */
    public function setFilesize($filesize)
    {
        $this->filesize = $filesize;

        return $this;
    }

    /**
     * Get filesize
     *
     * @return string 
     */
    public function getFilesize()
    {
        return $this->filesize;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return ManagedFile
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set timestamp
     *
     * @param \DateTime $timestamp
     * @return ManagedFile
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime 
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return ManagedFile
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set entity_id
     *
     * @param integer $entityId
     * @return ManagedFile
     */
    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

    /**
     * Get entity_id
     *
     * @return integer 
     */
    public function getEntityId()
    {
        return $this->entityId;
    }


    /**
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "message.list", "message.details"})
     * @VirtualProperty
     * @SerializedName("absolute_path")
     */
    public function getAbsolutePath()
    {

        return null === $this->path
            ? null
            : "http://".$_SERVER['SERVER_NAME'].'/n-darkish/web/uploads/'.$this->getUploadDir().'/'.$this->path;
    }


    /**
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "message.list", "message.details"})
     * @VirtualProperty
     * @SerializedName("video_thumbnail_absolute_path")
     */
    public function getVideoThumbnailAbsolutePath()
    {

        return null === $this->videoThumbnail
            ? null
            : "http://".$_SERVER['SERVER_NAME'].'/n-darkish/web/uploads/video_thumbnail/'.$this->videoThumbnail;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved

        return __DIR__.'/../../../../web/uploads/'.$this->getUploadDir();
    }

    /**
     * @Groups({"file.details", "record.details", "record.store", "product.list", "product.details", "news.details", "operator.details", "offer.details",  "sponsor.details", "classified.details", "customer.details", "message.list", "message.details"})
     * @VirtualProperty
     * @SerializedName("relative_path")
     */
    public function getRelativePath() {
        return 'uploads/'.$this->getUploadDir().'/'.$this->getPath();   
    }

    public function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return $this->uploadDir;
    }

    /**
     * Set uploadDir
     *
     * @param string $uploadDir
     * @return ManagedFile
     */
    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;

        return $this;
    }


    protected function getUploadKey()
    {

        return $this->uploadKey;
    }

    /**
     * Set uploadKey
     *
     * @param string $uploadKey
     * @return ManagedFile
     */
    public function setUploadKey($uploadKey)
    {
        $this->uploadKey = $uploadKey;

        return $this;
    }

    /**
     * @Assert\Callback
     */
//    public function fileValidation(ExecutionContextInterface $context) {
//        if($this->path) {
//            if(!$this->fileName) {
//                $context->buildViolation('fileName property should be set.')
//                    ->atPath('fileName')
//                    ->addViolation();
//            }
//            if(!$this->filemime) {
//                $context->buildViolation('filemime property should be set.')
//                    ->atPath('filemime')
//                    ->addViolation();
//            }
//            if(!$this->filesize) {
//                $context->buildViolation('filesize property should be set.')
//                    ->atPath('filesize')
//                    ->addViolation();
//            }
//
//
//        }else {
//            if($this->file == null) {
//                $context->buildViolation('file property should be set.')
//                    ->atPath('file')
//                    ->addViolation();
//            }
//        }
//
//    }

    public function upload()
    {

        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to
        if( $this->getFile() instanceof UploadedFile) {
            $fileName = $this->type.'-'.time().'-'.rand(10000, 99999).'.'.$this->getFile()->getClientOriginalExtension();    
        } else  {
            $fileName = $this->type.'-'.time().'-'.rand(10000, 99999).'.'.$this->getFile()->getExtension();    
        }
        
        $this->fileName = $fileName;
        $newFile = $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->fileName
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->fileName;

        $this->filemime = $newFile->getMimeType();
        $this->filesize = $newFile->getSize();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

    

    /**
     * Set isThumbnail
     *
     * @param boolean $isThumbnail
     * @return ManagedFile
     */
    public function setIsThumbnail($isThumbnail)
    {
        $this->isThumbnail = $isThumbnail;

        return $this;
    }

    /**
     * Get isThumbnail
     *
     * @return boolean 
     */
    public function getIsThumbnail()
    {
        return $this->isThumbnail;
    }

    /**
     * Set continual
     *
     * @param boolean $continual
     * @return ManagedFile
     */
    public function setContinual($continual)
    {
        $this->continual = $continual;

        return $this;
    }

    /**
     * Get continual
     *
     * @return boolean 
     */
    public function getContinual()
    {
        return $this->continual;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->iconForRecord = new \Doctrine\Common\Collections\ArrayCollection();

    }

    /**
     * Add iconForRecord
     *
     * @param \Darkish\CategoryBundle\Entity\Record $iconForRecord
     * @return ManagedFile
     */
    public function addIconForRecord(\Darkish\CategoryBundle\Entity\Record $iconForRecord)
    {
        $this->iconForRecord[] = $iconForRecord;

        return $this;
    }

    /**
     * Remove iconForRecord
     *
     * @param \Darkish\CategoryBundle\Entity\Record $iconForRecord
     */
    public function removeIconForRecord(\Darkish\CategoryBundle\Entity\Record $iconForRecord)
    {
        $this->iconForRecord->removeElement($iconForRecord);
    }

    /**
     * Get iconForRecord
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIconForRecord()
    {
        return $this->iconForRecord;
    }

    /**
     * Add iconForNews
     *
     * @param \Darkish\CategoryBundle\Entity\News $iconForNews
     * @return ManagedFile
     */
    public function addIconForNews(\Darkish\CategoryBundle\Entity\News $iconForNews)
    {
        $this->iconForNews[] = $iconForNews;

        return $this;
    }

    /**
     * Remove iconForNews
     *
     * @param \Darkish\CategoryBundle\Entity\News $iconForNews
     */
    public function removeIconForNews(\Darkish\CategoryBundle\Entity\News $iconForNews)
    {
        $this->iconForNews->removeElement($iconForNews);
    }

    /**
     * Get iconForNews
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIconForNews()
    {
        return $this->iconForNews;
    }

    /**
     * Add iconForOffer
     *
     * @param \Darkish\CategoryBundle\Entity\Offer $iconForOffer
     * @return ManagedFile
     */
    public function addIconForOffer(\Darkish\CategoryBundle\Entity\Offer $iconForOffer)
    {
        $this->iconForOffer[] = $iconForOffer;

        return $this;
    }

    /**
     * Remove iconForOffer
     *
     * @param \Darkish\CategoryBundle\Entity\Offer $iconForOffer
     */
    public function removeIconForOffer(\Darkish\CategoryBundle\Entity\Offer $iconForOffer)
    {
        $this->iconForOffer->removeElement($iconForOffer);
    }

    /**
     * Get iconForOffer
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIconForOffer()
    {
        return $this->iconForOffer;
    }

    /**
     * Add bannerForOffer
     *
     * @param \Darkish\CategoryBundle\Entity\Offer $bannerForOffer
     * @return ManagedFile
     */
    public function addBannerForOffer(\Darkish\CategoryBundle\Entity\Offer $bannerForOffer)
    {
        $this->bannerForOffer[] = $bannerForOffer;

        return $this;
    }

    /**
     * Remove bannerForOffer
     *
     * @param \Darkish\CategoryBundle\Entity\Offer $bannerForOffer
     */
    public function removeBannerForOffer(\Darkish\CategoryBundle\Entity\Offer $bannerForOffer)
    {
        $this->bannerForOffer->removeElement($bannerForOffer);
    }

    /**
     * Get bannerForOffer
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBannerForOffer()
    {
        return $this->bannerForOffer;
    }

    /**
     * Add iconForClassified
     *
     * @param \Darkish\CategoryBundle\Entity\Classified $iconForClassified
     * @return ManagedFile
     */
    public function addIconForClassified(\Darkish\CategoryBundle\Entity\Classified $iconForClassified)
    {
        $this->iconForClassified[] = $iconForClassified;

        return $this;
    }

    /**
     * Remove iconForClassified
     *
     * @param \Darkish\CategoryBundle\Entity\Classified $iconForClassified
     */
    public function removeIconForClassified(\Darkish\CategoryBundle\Entity\Classified $iconForClassified)
    {
        $this->iconForClassified->removeElement($iconForClassified);
    }

    /**
     * Get iconForClassified
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIconForClassified()
    {
        return $this->iconForClassified;
    }

    /**
     * Add recordForMarketBanner
     *
     * @param \Darkish\CategoryBundle\Entity\Record $recordForMarketBanner
     * @return ManagedFile
     */
    public function addRecordForMarketBanner(\Darkish\CategoryBundle\Entity\Record $recordForMarketBanner)
    {
        $this->recordForMarketBanner[] = $recordForMarketBanner;

        return $this;
    }

    /**
     * Remove recordForMarketBanner
     *
     * @param \Darkish\CategoryBundle\Entity\Record $recordForMarketBanner
     */
    public function removeRecordForMarketBanner(\Darkish\CategoryBundle\Entity\Record $recordForMarketBanner)
    {
        $this->recordForMarketBanner->removeElement($recordForMarketBanner);
    }

    /**
     * Get recordForMarketBanner
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecordForMarketBanner()
    {
        return $this->recordForMarketBanner;
    }

    /**
     * Add recordForDbaseBanner
     *
     * @param \Darkish\CategoryBundle\Entity\Record $recordForDbaseBanner
     * @return ManagedFile
     */
    public function addRecordForDbaseBanner(\Darkish\CategoryBundle\Entity\Record $recordForDbaseBanner)
    {
        $this->recordForDbaseBanner[] = $recordForDbaseBanner;

        return $this;
    }

    /**
     * Remove recordForDbaseBanner
     *
     * @param \Darkish\CategoryBundle\Entity\Record $recordForDbaseBanner
     */
    public function removeRecordForDbaseBanner(\Darkish\CategoryBundle\Entity\Record $recordForDbaseBanner)
    {
        $this->recordForDbaseBanner->removeElement($recordForDbaseBanner);
    }

    /**
     * Get recordForDbaseBanner
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecordForDbaseBanner()
    {
        return $this->recordForDbaseBanner;
    }

    /**
     * Add recordAsBodyImage
     *
     * @param \Darkish\CategoryBundle\Entity\Record $recordAsBodyImage
     *
     * @return ManagedFile
     */
    public function addRecordAsBodyImage(\Darkish\CategoryBundle\Entity\Record $recordAsBodyImage)
    {
        $this->recordAsBodyImage[] = $recordAsBodyImage;

        return $this;
    }

    /**
     * Remove recordAsBodyImage
     *
     * @param \Darkish\CategoryBundle\Entity\Record $recordAsBodyImage
     */
    public function removeRecordAsBodyImage(\Darkish\CategoryBundle\Entity\Record $recordAsBodyImage)
    {
        $this->recordAsBodyImage->removeElement($recordAsBodyImage);
    }

    /**
     * Get recordAsBodyImage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecordAsBodyImage()
    {
        return $this->recordAsBodyImage;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ManagedFile
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
     * Add iconForSponsor
     *
     * @param \Darkish\CategoryBundle\Entity\Sponsor $iconForSponsor
     *
     * @return ManagedFile
     */
    public function addIconForSponsor(\Darkish\CategoryBundle\Entity\Sponsor $iconForSponsor)
    {
        $this->iconForSponsor[] = $iconForSponsor;

        return $this;
    }

    /**
     * Remove iconForSponsor
     *
     * @param \Darkish\CategoryBundle\Entity\Sponsor $iconForSponsor
     */
    public function removeIconForSponsor(\Darkish\CategoryBundle\Entity\Sponsor $iconForSponsor)
    {
        $this->iconForSponsor->removeElement($iconForSponsor);
    }

    /**
     * Get iconForSponsor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIconForSponsor()
    {
        return $this->iconForSponsor;
    }

    /**
     * Add bannerForSponsor
     *
     * @param \Darkish\CategoryBundle\Entity\Sponsor $bannerForSponsor
     *
     * @return ManagedFile
     */
    public function addBannerForSponsor(\Darkish\CategoryBundle\Entity\Sponsor $bannerForSponsor)
    {
        $this->bannerForSponsor[] = $bannerForSponsor;

        return $this;
    }

    /**
     * Remove bannerForSponsor
     *
     * @param \Darkish\CategoryBundle\Entity\Sponsor $bannerForSponsor
     */
    public function removeBannerForSponsor(\Darkish\CategoryBundle\Entity\Sponsor $bannerForSponsor)
    {
        $this->bannerForSponsor->removeElement($bannerForSponsor);
    }

    /**
     * Get bannerForSponsor
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBannerForSponsor()
    {
        return $this->bannerForSponsor;
    }

    /**
     * Set videoThumbnail
     *
     * @param string $videoThumbnail
     *
     * @return ManagedFile
     */
    public function setVideoThumbnail($videoThumbnail)
    {
        $this->videoThumbnail = $videoThumbnail;

        return $this;
    }

    /**
     * Get videoThumbnail
     *
     * @return string
     */
    public function getVideoThumbnail()
    {
        return $this->videoThumbnail;
    }

    /**
     * Add newsAsBodyImage
     *
     * @param \Darkish\CategoryBundle\Entity\News $newsAsBodyImage
     *
     * @return ManagedFile
     */
    public function addNewsAsBodyImage(\Darkish\CategoryBundle\Entity\News $newsAsBodyImage)
    {
        $this->newsAsBodyImage[] = $newsAsBodyImage;

        return $this;
    }

    /**
     * Remove newsAsBodyImage
     *
     * @param \Darkish\CategoryBundle\Entity\News $newsAsBodyImage
     */
    public function removeNewsAsBodyImage(\Darkish\CategoryBundle\Entity\News $newsAsBodyImage)
    {
        $this->newsAsBodyImage->removeElement($newsAsBodyImage);
    }

    /**
     * Get newsAsBodyImage
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNewsAsBodyImage()
    {
        return $this->newsAsBodyImage;
    }

    /**
     * Set darkishWatermark
     *
     * @param boolean $darkishWatermark
     *
     * @return ManagedFile
     */
    public function setDarkishWatermark($darkishWatermark)
    {
        $this->darkishWatermark = $darkishWatermark;

        return $this;
    }

    /**
     * Get darkishWatermark
     *
     * @return boolean
     */
    public function getDarkishWatermark()
    {
        return $this->darkishWatermark;
    }

    /**
     * Set islandWatermark
     *
     * @param boolean $islandWatermark
     *
     * @return ManagedFile
     */
    public function setIslandWatermark($islandWatermark)
    {
        $this->islandWatermark = $islandWatermark;

        return $this;
    }

    /**
     * Get islandWatermark
     *
     * @return boolean
     */
    public function getIslandWatermark()
    {
        return $this->islandWatermark;
    }

    /**
     * Set arunaWatermark
     *
     * @param boolean $arunaWatermark
     *
     * @return ManagedFile
     */
    public function setArunaWatermark($arunaWatermark)
    {
        $this->arunaWatermark = $arunaWatermark;

        return $this;
    }

    /**
     * Get arunaWatermark
     *
     * @return boolean
     */
    public function getArunaWatermark()
    {
        return $this->arunaWatermark;
    }

    /**
     * Set labelWatermark
     *
     * @param boolean $labelWatermark
     *
     * @return ManagedFile
     */
    public function setLabelWatermark($labelWatermark)
    {
        $this->labelWatermark = $labelWatermark;

        return $this;
    }

    /**
     * Get labelWatermark
     *
     * @return boolean
     */
    public function getLabelWatermark()
    {
        return $this->labelWatermark;
    }

    /**
     * Set checked
     *
     * @param boolean $checked
     *
     * @return ManagedFile
     */
    public function setChecked($checked)
    {
        $this->checked = $checked;

        return $this;
    }

    /**
     * Get checked
     *
     * @return boolean
     */
    public function getChecked()
    {
        return $this->checked;
    }

    public function setOneup($oneup)
    {
        $this->oneup = $oneup;

        return $oneup;
    }

    /**
     * Get oneup
     *
     * @return boolean
     */
    public function getOneup()
    {
        return $this->oneup;
    }
}
