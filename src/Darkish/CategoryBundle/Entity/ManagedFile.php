<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile as UploadedFile;
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
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     *
     * @Assert\NotNull()
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="file_name", type="string", length=255)
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="filemime", type="string", length=255)
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     */
    private $filemime;

    /**
     * @var string
     *
     * @ORM\Column(name="filesize", type="string", length=255)
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     */
    private $filesize;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     *
     */
    private $status;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="continual", type="boolean", nullable=true, options={"default":0})
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     *
     */
    private $continual;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="is_thumbnail", type="boolean", nullable=true, options={"default":0})
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     *
     */
    private $isThumbnail;
    
    /**
     *
     * @var string 
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     */
    private $resizedAbsolutePath;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetimetz")
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     */
    private $timestamp;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=true)
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     *
     * @Assert\Choice(choices = {"news", "classified", "offer", "record", "operator", "customer"}, message = "input a valid entity type.")
     *
     * @Assert\NotNull()
     */
    private $type;

    /**
     * @var integer
     *
     * @ORM\Column(name="entity_id", type = "integer", nullable=true)
     *
     *
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     */
    private $entityId;


    /**
     * @var string
     *
     * @ORM\Column(name="upload_dir", type="string", nullable=true)
     *
     * @Assert\Choice(choices = {"image", "video", "audio", "icon", "doc", "banner"}, message = "Input a valid uploadDir.")
     *
     * @Assert\NotNull()
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     */
    private $uploadDir;


    /**
     * @var string
     *
     * @ORM\Column(name="upload_key", type="string", nullable=true)
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     * 
     */
    private $uploadKey;
    
    /**
     * @ORM\OneToMany(targetEntity="Record", mappedBy="icon")
     */
    protected $iconForRecord;
    
    /**
     * @ORM\OneToMany(targetEntity="News", mappedBy="icon")
     */
    protected $iconForNews;

    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="icon")
     */
    protected $iconForOffer;
    
    /**
     * @ORM\OneToMany(targetEntity="Offer", mappedBy="banner")
     */
    protected $bannerForOffer;
    
    /**
     * @ORM\OneToMany(targetEntity="Classified", mappedBy="icon")
     */
    protected $iconForClassified;
    
    /**
     * @ORM\OneToMany(targetEntity="Classified", mappedBy="banner")
     */
    protected $bannerForClassified;


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
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

    public function setResizedAbsolutePath($path) {
        $this->resizedAbsolutePath = $path;
        
        return $this;
    }
    
    
    /**
     * 
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     * @VirtualProperty
     * @SerializedName("absolute_path")
     */
    public function getResizedAbsolutePath() { 
        return $this->resizedAbsolutePath;
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
     * @Groups({"record.details", "news.details", "operator.details", "offer.details", "classified.details", "customer.details"})
     * @VirtualProperty
     * @SerializedName("absolute_path")
     */
    public function getAbsolutePath()
    {

        return null === $this->path
            ? null
            : "http://".$_SERVER['SERVER_NAME'].'/n-darkish/web/uploads/'.$this->getUploadDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved

        return __DIR__.'/../../../../web/uploads/'.$this->getUploadDir();
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
    public function fileValidation(ExecutionContextInterface $context) {
        if($this->path) {
            if(!$this->fileName) {
                $context->buildViolation('fileName property should be set.')
                    ->atPath('fileName')
                    ->addViolation();
            }
            if(!$this->filemime) {
                $context->buildViolation('filemime property should be set.')
                    ->atPath('filemime')
                    ->addViolation();
            }
            if(!$this->filesize) {
                $context->buildViolation('filesize property should be set.')
                    ->atPath('filesize')
                    ->addViolation();
            }


        }else {
            if($this->file == null) {
                $context->buildViolation('file property should be set.')
                    ->atPath('file')
                    ->addViolation();
            }
        }

    }

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

        $fileName = $this->type.'-'.time().'-'.rand(10000, 99999).'.'.$this->getFile()->getClientOriginalExtension();
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
}
