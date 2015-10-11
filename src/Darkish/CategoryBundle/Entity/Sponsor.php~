<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Sponsor
 *
 * @ORM\Table(name="sponsor")
 * @ORM\Entity(repositoryClass="Darkish\CategoryBundle\Entity\SponsorRepository")
 */
class Sponsor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"sponsor.list", "sponsor.details", "api.list"})
     */
    private $id;

    


    /**
     * @var string
     * @ORM\Column(name="Title", type="string", length=255)
     * @Groups({"sponsor.list", "sponsor.details", "api.list"})
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
     * @Groups({"sponsor.list", "sponsor.details", "api.list"})
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
     * @Groups({"sponsor.details"})
     */
    private $creationDate;
    
    /**
     * @ORM\Column(name="MainSponsor", type="boolean", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $mainSponsor;
    

    /**
     * @var string
     *
     * @ORM\Column(name="LastUpdate", type="datetime", nullable=false)
     * @Groups({"sponsor.details"})
     */
    private $lastUpdate;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="HtmlLastUpdate", type="datetime", nullable=false)
     * @Groups({"sponsor.details"})
     */
    private $htmlLastUpdate;

    /**
     * @var datetime
     *
     * @ORM\Column(name="PublishDate", type="datetime", nullable=true)
     * @Groups({"sponsor.details", "api.list"})
     */
    private $publishDate;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="ExpireDate", type="datetime", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $expireDate;
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="Continual", type="boolean", nullable=true, options={"default":0})
     * @Groups({"sponsor.details"}) 
     */
    private $continual;
    
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="Immediate", type="boolean", nullable=true, options={"default":0})
     * @Groups({"sponsor.details"}) 
     */
    private $immediate;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="ListRank", type="integer", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $listRank;
    
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="IsCompetition", type="boolean", nullable=true, options={"default":0})
     * @Groups({"sponsor.details"}) 
     */
    private $isCompetition;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="TrueAnswer", type="integer", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $trueAnswer;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="Rate", type="integer", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $rate;
    

    
    

    /**
     * @var string
     *
     * @ORM\Column(name="Body", type="text", nullable=true)
     * @Groups({"sponsor.details", "api.body"})
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
     * @Groups({"sponsor.details", "api.body"})
     */
    private $submitterNumber;


    /**
     * @var string
     *
     * @ORM\Column(name="SubmitterTitle", type="string", nullable=true)
     * @Groups({"sponsor.details", "api.body"})
     */
    private $submitterTitle;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Audio", type="boolean", nullable=true)
     * @Groups({"sponsor.details", "api.list"})
     */
    private $audio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Video", type="boolean", nullable=true)
     * @Groups({"sponsor.details", "api.list"})
     */
    private $video;

    
    /**
     * @ORM\Column(name="VisitCount", type="integer", nullable=true, options={"default"=0})
     * @Groups({"sponsor.details", "api.list"})
     */
    private $visitCount;

    

    /**
     * @var boolean
     *
     * @ORM\Column(name="Active", type="boolean", nullable=false, options={"default":0})
     * @Groups({"sponsor.details"})
     */
    private $active;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Verify", type="boolean", nullable=false, options={"default": 0})
     * @Groups({"sponsor.details"})
     */
    private $verify;

    
    
    /**
     * @var string
     *
     * @ORM\Column(name="Address", type="string", length=255, nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberOne", type="bigint", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $telNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberTwo", type="bigint", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $telNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberThree", type="bigint", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $telNumberThree;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberFour", type="bigint", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $telNumberFour;

    /**
     * @var string
     *
     * @ORM\Column(name="FaxNumberOne", type="bigint", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $faxNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="FaxNumberTwo", type="bigint", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $faxNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="MobileNumberOne", type="bigint", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $mobileNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="MobileNumberTwo", type="bigint", nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $mobileNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Website", type="string", length=255, nullable=true)
     * @Groups({"sponsor.details"})
     */
    private $website;
    
    

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $trees
     *
     * @Groups({"sponsor.details"})
     *
     * @ORM\ManyToMany(targetEntity="Darkish\CategoryBundle\Entity\SponsorTree", inversedBy="sponsor")
     * @ORM\JoinTable(name="sponsor_sponsortrees",
     *      joinColumns={@ORM\JoinColumn(name="sponsor_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="sponsortree_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
//    private $trees;

    /**
     * @ORM\OneToMany(targetEntity="SponsorSponsorTree", mappedBy="sponsor", cascade={"remove"})
     * @Groups({"sponsor.details", "api.list"})
     **/
    private $sponsortrees;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="sponsor_images",
     *      joinColumns={@ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"sponsor.details"})
     **/
    private $images;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ManagedFile", inversedBy="iconForSponsor")
     * @ORM\JoinColumn(name="IconIndex", referencedColumnName="id")
     * @Groups({"sponsor.details"})
     * 
     **/
    private $icon;
    
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ManagedFile", inversedBy="bannerForSponsor")
     * @ORM\JoinColumn(name="BannerIndex", referencedColumnName="id")
     * @Groups({"sponsor.details", "api.list"})
     * 
     **/
    private $banner;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ManagedFile")
     * @ORM\JoinColumn(name="VerticalBannerIndex", referencedColumnName="id")
     * @Groups({"sponsor.details", "api.list"})
     *
     **/
    private $verticalBanner;
    

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="sponsor_body_images",
     *      joinColumns={@ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"sponsor.details"})
     **/
    private $bodyImages;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="sponsor_videos",
     *      joinColumns={@ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"sponsor.details"})
     **/
    private $videos;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="sponsor_body_videos",
     *      joinColumns={@ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"sponsor.details"})
     **/
    private $bodyVideos;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="sponsor_audios",
     *      joinColumns={@ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"sponsor.details"})
     **/
    private $audios;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="sponsor_body_audios",
     *      joinColumns={@ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"sponsor.details"})
     **/
    private $bodyAudios;
    
    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="sponsor_body_docs",
     *      joinColumns={@ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"sponsor.details"})
     **/
    private $bodyDocs;


    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="\Darkish\UserBundle\Entity\Operator", inversedBy="sponsor")
     * @ORM\JoinColumn(name="UserId", referencedColumnName="id")
     * @Groups({"sponsor.details"})
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @param \Darkish\CategoryBundle\Entity\SponsorTree $trees
     * @return Sponsor
     */
    public function addTree(\Darkish\CategoryBundle\Entity\SponsorTree $tree)
    {
        $this->trees[] = $tree;

        return $this;
    }

    /**
     * Remove tree
     *
     * @param \Darkish\CategoryBundle\Entity\SponsorTree $tree
     */
    public function removeTree(\Darkish\CategoryBundle\Entity\SponsorTree $tree)
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * Add sponsortrees
     *
     * @param \Darkish\CategoryBundle\Entity\SponsorSponsorTree $sponsortrees
     * @return Sponsor
     */
    public function addSponsortree(\Darkish\CategoryBundle\Entity\SponsorSponsorTree $sponsortrees)
    {
        $this->sponsortrees[] = $sponsortrees;

        return $this;
    }

    /**
     * Remove sponsortrees
     *
     * @param \Darkish\CategoryBundle\Entity\SponsorSponsorTree $sponsortrees
     */
    public function removeSponsortree(\Darkish\CategoryBundle\Entity\SponsorSponsorTree $sponsortrees)
    {
        $this->sponsortrees->removeElement($sponsortrees);
    }

    /**
     * Get sponsortrees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSponsortrees()
    {
        return $this->sponsortrees;
    }

    /**
     * Set visitCount
     *
     * @param integer $visitCount
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * @return Sponsor
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
     * Set mainSponsor
     *
     * @param boolean $mainSponsor
     *
     * @return Sponsor
     */
    public function setMainSponsor($mainSponsor)
    {
        $this->mainSponsor = $mainSponsor;

        return $this;
    }

    /**
     * Get mainSponsor
     *
     * @return boolean
     */
    public function getMainSponsor()
    {
        return $this->mainSponsor;
    }

    /**
     * Set verticalBanner
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $verticalBanner
     *
     * @return Sponsor
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
     * @return Sponsor
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
