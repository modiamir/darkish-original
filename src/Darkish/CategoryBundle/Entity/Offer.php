<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Offer
 *
 * @ORM\Table(name="offer")
 * @ORM\Entity(repositoryClass="Darkish\CategoryBundle\Entity\OfferRepository")
 */
class Offer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"offer.list", "offer.details", "api.list", "api.body"})
     */
    private $id;

    


    /**
     * @var string
     * @ORM\Column(name="Title", type="string", length=255)
     * @Groups({"offer.list", "offer.details", "api.list", "api.body"})
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
     * @Groups({"offer.list", "offer.details", "api.list", "api.body"})
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
     * @var datetime
     *
     * @ORM\Column(name="CreationDate", type="datetime", nullable=false)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $creationDate;
    
    
    
    

    /**
     * @var string
     *
     * @ORM\Column(name="LastUpdate", type="datetime", nullable=false)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $lastUpdate;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="HtmlLastUpdate", type="datetime", nullable=false)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $htmlLastUpdate;

    /**
     * @var datetime
     *
     * @ORM\Column(name="PublishDate", type="datetime", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $publishDate;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="ExpireDate", type="datetime", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $expireDate;
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="Continual", type="boolean", nullable=true, options={"default":0})
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $continual;
    
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="Immediate", type="boolean", nullable=true, options={"default":0})
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $immediate;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="ListRank", type="integer", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $listRank;
    
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="IsCompetition", type="boolean", nullable=true, options={"default":0})
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $isCompetition;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="TrueAnswer", type="integer", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $trueAnswer;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="Rate", type="integer", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $rate;
    

    
    

    /**
     * @var string
     *
     * @ORM\Column(name="Body", type="text", nullable=true)
     * @Groups({"offer.details", "api.body", "api.list"})
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
     * @var string
     *
     * @ORM\Column(name="SubmitterNumber", type="string", nullable=true)
     * @Groups({"offer.details", "api.body", "api.list"})
     */
    private $submitterNumber;


    /**
     * @var string
     *
     * @ORM\Column(name="SubmitterTitle", type="string", nullable=true)
     * @Groups({"offer.details", "api.body", "api.list"})
     */
    private $submitterTitle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Audio", type="boolean", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $audio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Video", type="boolean", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $video;

    
    /**
     * @ORM\Column(name="VisitCount", type="integer", nullable=true, options={"default"=0})
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $visitCount;

    

    /**
     * @var boolean
     *
     * @ORM\Column(name="Active", type="boolean", nullable=false, options={"default":0})
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $active;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Verify", type="boolean", nullable=false, options={"default": 0})
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $verify;

    
    
    /**
     * @var string
     *
     * @ORM\Column(name="Address", type="string", length=255, nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberOne", type="bigint", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $telNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberTwo", type="bigint", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $telNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberThree", type="bigint", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $telNumberThree;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberFour", type="bigint", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $telNumberFour;

    /**
     * @var string
     *
     * @ORM\Column(name="FaxNumberOne", type="bigint", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $faxNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="FaxNumberTwo", type="bigint", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $faxNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="MobileNumberOne", type="bigint", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $mobileNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="MobileNumberTwo", type="bigint", nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $mobileNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Website", type="string", length=255, nullable=true)
     * @Groups({"offer.details", "api.list", "api.body"})
     */
    private $website;
    
    

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $trees
     *
     * @Groups({"offer.details", "api.list", "api.body"})
     *
     * @ORM\ManyToMany(targetEntity="Darkish\CategoryBundle\Entity\OfferTree", inversedBy="offer")
     * @ORM\JoinTable(name="offer_offertrees",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="offertree_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
//    private $trees;

    /**
     * @ORM\OneToMany(targetEntity="OfferOfferTree", mappedBy="offer", cascade={"remove", "persist"})
     * @Groups({"offer.details", "api.list", "api.body"})
     **/
    private $offertrees;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile", cascade={"remove"})
     * @ORM\JoinTable(name="offer_images",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"offer.details", "api.list", "api.body"})
     **/
    private $images;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ManagedFile", inversedBy="iconForOffer")
     * @ORM\JoinColumn(name="IconIndex", referencedColumnName="id", onDelete="CASCADE")
     * @Groups({"offer.details", "api.list", "api.body"})
     * 
     **/
    private $icon;
    
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ManagedFile", inversedBy="bannerForOffer")
     * @ORM\JoinColumn(name="BannerIndex", referencedColumnName="id", onDelete="CASCADE")
     * @Groups({"offer.details", "api.list", "api.body"})
     * 
     **/
    private $banner;


    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ManagedFile")
     * @ORM\JoinColumn(name="VerticalBannerIndex", referencedColumnName="id")
     * @Groups({"offer.details", "api.list", "api.body"})
     *
     **/
    private $verticalBanner;
    

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="offer_body_images",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"offer.details"})
     **/
    private $bodyImages;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="offer_videos",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"offer.details"})
     **/
    private $videos;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="offer_body_videos",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"offer.details"})
     **/
    private $bodyVideos;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="offer_audios",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"offer.details"})
     **/
    private $audios;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="offer_body_audios",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"offer.details"})
     **/
    private $bodyAudios;
    
    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="offer_body_docs",
     *      joinColumns={@ORM\JoinColumn(name="offer_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"offer.details"})
     **/
    private $bodyDocs;


    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="\Darkish\UserBundle\Entity\Operator", inversedBy="offer")
     * @ORM\JoinColumn(name="UserId", referencedColumnName="id")
     * @Groups({"offer.details"})
     */
    private $user;




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
     * @return Offer
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
     * @return Offer
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
     * Set verify
     *
     * @param boolean $verify
     * @return Offer
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
     * Add trees
     *
     * @param \Darkish\CategoryBundle\Entity\OfferTree $trees
     * @return Offer
     */
    public function addTree(\Darkish\CategoryBundle\Entity\OfferTree $tree)
    {
        $this->trees[] = $tree;

        return $this;
    }

    /**
     * Remove tree
     *
     * @param \Darkish\CategoryBundle\Entity\OfferTree $tree
     */
    public function removeTree(\Darkish\CategoryBundle\Entity\OfferTree $tree)
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
    }


    

    /**
     * Add images
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $images
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * Set icon
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $icon
     * @return Offer
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
        return $this->icon;
    }

   

    /**
     * Add bodyDocs
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $bodyDocs
     * @return Offer
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
     * @return Offer
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
     * Set publishDate
     *
     * @param \DateTime $publishDate
     * @return Offer
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * Get publishDate
     *
     * @return \DateTime 
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set expireDate
     *
     * @param \DateTime $expireDate
     * @return Offer
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
     * Set audio
     *
     * @param boolean $audio
     * @return Offer
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
     * @return Offer
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
     * Set isCompetition
     *
     * @param boolean $isCompetition
     * @return Offer
     */
    public function setIsCompetition($isCompetition)
    {
        $this->isCompetition = $isCompetition;

        return $this;
    }

    /**
     * Get isCompetition
     *
     * @return boolean 
     */
    public function getIsCompetition()
    {
        return $this->isCompetition;
    }

    /**
     * Set trueAnswer
     *
     * @param integer $trueAnswer
     * @return Offer
     */
    public function setTrueAnswer($trueAnswer)
    {
        $this->trueAnswer = $trueAnswer;

        return $this;
    }

    /**
     * Get trueAnswer
     *
     * @return integer 
     */
    public function getTrueAnswer()
    {
        return $this->trueAnswer;
    }

    /**
     * Set rate
     *
     * @param integer $rate
     * @return Offer
     */
    public function setRate($rate)
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * Get rate
     *
     * @return integer 
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set htmlLastUpdate
     *
     * @param \DateTime $htmlLastUpdate
     * @return Offer
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
     * Set continual
     *
     * @param boolean $continual
     * @return Offer
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
     * Set immediate
     *
     * @param boolean $immediate
     * @return Offer
     */
    public function setImmediate($immediate)
    {
        $this->immediate = $immediate;

        return $this;
    }

    /**
     * Get immediate
     *
     * @return boolean 
     */
    public function getImmediate()
    {
        return $this->immediate;
    }

    /**
     * Set listRank
     *
     * @param integer $listRank
     * @return Offer
     */
    public function setListRank($listRank)
    {
        $this->listRank = $listRank;

        return $this;
    }

    /**
     * Get listRank
     *
     * @return integer 
     */
    public function getListRank()
    {
        return $this->listRank;
    }

    /**
     * Set banner
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $banner
     * @return Offer
     */
    public function setBanner(\Darkish\CategoryBundle\Entity\ManagedFile $banner = null)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return \Darkish\CategoryBundle\Entity\ManagedFile 
     */
    public function getBanner()
    {
        return $this->banner;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Offer
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
     * Set telNumberOne
     *
     * @param string $telNumberOne
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * @return Offer
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
     * Set email
     *
     * @param string $email
     * @return Offer
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
     * @return Offer
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
     * Add offertrees
     *
     * @param \Darkish\CategoryBundle\Entity\OfferOfferTree $offertrees
     * @return Offer
     */
    public function addOffertree(\Darkish\CategoryBundle\Entity\OfferOfferTree $offertrees)
    {
        $this->offertrees[] = $offertrees;

        return $this;
    }

    /**
     * Remove offertrees
     *
     * @param \Darkish\CategoryBundle\Entity\OfferOfferTree $offertrees
     */
    public function removeOffertree(\Darkish\CategoryBundle\Entity\OfferOfferTree $offertrees)
    {
        $this->offertrees->removeElement($offertrees);
    }

    /**
     * Get offertrees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOffertrees()
    {
        return $this->offertrees;
    }

    /**
     * Set visitCount
     *
     * @param integer $visitCount
     * @return Offer
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
     * Set likeCount
     *
     * @param integer $likeCount
     * @return Offer
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
     * Set submitterNumber
     *
     * @param string $submitterNumber
     *
     * @return Offer
     */
    public function setSubmitterNumber($submitterNumber)
    {
        $this->submitterNumber = $submitterNumber;

        return $this;
    }

    /**
     * Get submitterNumber
     *
     * @return string
     */
    public function getSubmitterNumber()
    {
        return $this->submitterNumber;
    }

    /**
     * Set submitterTitle
     *
     * @param string $submitterTitle
     *
     * @return Offer
     */
    public function setSubmitterTitle($submitterTitle)
    {
        $this->submitterTitle = $submitterTitle;

        return $this;
    }

    /**
     * Get submitterTitle
     *
     * @return string
     */
    public function getSubmitterTitle()
    {
        return $this->submitterTitle;
    }

    /**
     * Set verticalBanner
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $verticalBanner
     *
     * @return Offer
     */
    public function setVerticalBanner(\Darkish\CategoryBundle\Entity\ManagedFile $verticalBanner = null)
    {
        $this->verticalBanner = $verticalBanner;

        return $this;
    }

    /**
     * Get verticalBanner
     *
     * @return \Darkish\CategoryBundle\Entity\ManagedFile
     */
    public function getVerticalBanner()
    {
        return $this->verticalBanner;
    }

    /**
     * Set webBody
     *
     * @param string $webBody
     *
     * @return Offer
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
}
