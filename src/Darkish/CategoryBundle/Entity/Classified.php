<?php

namespace Darkish\CategoryBundle\Entity;

use Darkish\CategoryBundle\Entity\Interfaces\ClaimableInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Classified
 *
 * @ORM\Table(name="classified")
 * @ORM\Entity(repositoryClass="Darkish\CategoryBundle\Entity\ClassifiedRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"general" = "Classified", "client" = "ClientClassified"})
 */
class Classified implements ClaimableInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"classified.list", "classified.details", "api.list", "api.body"})
     */
    protected $id;

    


    /**
     * @var string
     * @ORM\Column(name="Title", type="string", length=255)
     * @Groups({"classified.list", "classified.details", "api.list", "api.body"})
     * @Assert\Length(
     *      min = "2",
     *      max = "70",
     *      maxMessage = "طول عنوان نمیتواند بیشتر از {{ limit }} کاراکتر باشد",
     *      minMessage = "طول عنوان نمیتواند کمتر از {{ limit }} باشد"
     * )
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="SubTitle", type="string", length=255, nullable=true)
     * @Groups({"classified.list", "classified.details", "api.list", "api.body"})
     * @Assert\Length(
     *      min = "2",
     *      max = "70",
     *      maxMessage = "طول زیرعنوان نمیتواند بیشتر از {{ limit }} باشد",
     *      minMessage = "طول زیرعنوان نمیتواند کمتر از {{ limit }} باشد"
     * )
     *
     */
    protected $subTitle;

    
    /**
     * @var datetime
     *
     * @ORM\Column(name="CreationDate", type="datetime", nullable=false)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $creationDate;
    
    
    
    

    /**
     * @var string
     *
     * @ORM\Column(name="LastUpdate", type="datetime", nullable=false)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $lastUpdate;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="HtmlLastUpdate", type="datetime", nullable=false)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $htmlLastUpdate;

    /**
     * @var datetime
     *
     * @ORM\Column(name="PublishDate", type="datetime", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $publishDate;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="ExpireDate", type="datetime", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $expireDate;
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="Continual", type="boolean", nullable=true, options={"default":0})
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $continual;
    

    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="ListRank", type="integer", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $listRank;
    
    

    /**
     * @var string
     *
     * @ORM\Column(name="Body", type="text", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $body;

    /**
     * @var string
     *
     * @ORM\Column(name="WebBody", type="text", nullable=true)
     * @Groups({"record.details", "api.body"})
     */
    protected $webBody;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Audio", type="boolean", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $audio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Video", type="boolean", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $video;

    
    /**
     * @ORM\Column(name="VisitCount", type="integer", nullable=true, options={"default"=0})
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $visitCount = 0;


    /**
     * @ORM\Column(name="price", type="bigint", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $price;
    

    /**
     * @var boolean
     *
     * @ORM\Column(name="Active", type="boolean", nullable=false, options={"default":0})
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $active;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Verify", type="boolean", nullable=false, options={"default": 0})
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $verify;

    /**
     * @ORM\ManyToOne(targetEntity="ClassifiedClaimTypes")
     */
    protected $claimType;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="Address", type="string", length=255, nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $address;
    
    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberOne", type="bigint", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $telNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberTwo", type="bigint", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $telNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberThree", type="bigint", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $telNumberThree;

    /**
     * @var string
     *
     * @ORM\Column(name="TelNumberFour", type="bigint", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $telNumberFour;

    /**
     * @var string
     *
     * @ORM\Column(name="FaxNumberOne", type="bigint", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $faxNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="FaxNumberTwo", type="bigint", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $faxNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="MobileNumberOne", type="bigint", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $mobileNumberOne;

    /**
     * @var string
     *
     * @ORM\Column(name="MobileNumberTwo", type="bigint", nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $mobileNumberTwo;

    /**
     * @var string
     *
     * @ORM\Column(name="Email", type="string", length=255, nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $email;

    /**
     * @var string
     *
     * @ORM\Column(name="Website", type="string", length=255, nullable=true)
     * @Groups({"classified.details", "api.list", "api.body"})
     */
    protected $website;
    
    

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $trees
     *
     * @Groups({"classified.details", "api.list", "api.body"})
     *
     * @ORM\ManyToMany(targetEntity="Darkish\CategoryBundle\Entity\ClassifiedTree", inversedBy="classified")
     * @ORM\JoinTable(name="classified_classifiedtrees",
     *      joinColumns={@ORM\JoinColumn(name="classified_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="classifiedtree_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
//    protected $trees;

    /**
     * @ORM\OneToMany(targetEntity="ClassifiedClassifiedTree", mappedBy="classified", cascade={"remove", "persist"})
     * @Groups({"classified.details", "api.list", "api.body"})
     **/
    protected $classifiedtrees;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile", cascade={"remove", "persist"})
     * @ORM\JoinTable(name="classified_images",
     *      joinColumns={@ORM\JoinColumn(name="classified_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"classified.details", "api.list", "api.body"})
     **/
    protected $images;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ManagedFile", inversedBy="iconForClassified")
     * @ORM\JoinColumn(name="IconIndex", referencedColumnName="id")
     * @Groups({"classified.details", "api.list", "api.body"})
     * 
     **/
    protected $icon;
    
    
    

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="classified_body_images",
     *      joinColumns={@ORM\JoinColumn(name="classified_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"classified.details"})
     **/
    protected $bodyImages;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="classified_videos",
     *      joinColumns={@ORM\JoinColumn(name="classified_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"classified.details"})
     **/
    protected $videos;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="classified_body_videos",
     *      joinColumns={@ORM\JoinColumn(name="classified_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"classified.details"})
     **/
    protected $bodyVideos;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="classified_audios",
     *      joinColumns={@ORM\JoinColumn(name="classified_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"classified.details"})
     **/
    protected $audios;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="classified_body_audios",
     *      joinColumns={@ORM\JoinColumn(name="classified_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"classified.details"})
     **/
    protected $bodyAudios;
    
    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="classified_body_docs",
     *      joinColumns={@ORM\JoinColumn(name="classified_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"classified.details"})
     **/
    protected $bodyDocs;


    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="\Darkish\UserBundle\Entity\Operator", inversedBy="classified")
     * @ORM\JoinColumn(name="UserId", referencedColumnName="id")
     * @Groups({"classified.details"})
     */
    protected $user;




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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @param \Darkish\CategoryBundle\Entity\ClassifiedTree $trees
     * @return Classified
     */
    public function addTree(\Darkish\CategoryBundle\Entity\ClassifiedTree $tree)
    {
        $this->trees[] = $tree;

        return $this;
    }

    /**
     * Remove tree
     *
     * @param \Darkish\CategoryBundle\Entity\ClassifiedTree $tree
     */
    public function removeTree(\Darkish\CategoryBundle\Entity\ClassifiedTree $tree)
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * @return Classified
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
     * Add classifiedtrees
     *
     * @param \Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree $classifiedtrees
     * @return Classified
     */
    public function addClassifiedtree(\Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree $classifiedtrees)
    {
        $this->classifiedtrees[] = $classifiedtrees;

        return $this;
    }

    /**
     * Remove classifiedtrees
     *
     * @param \Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree $classifiedtrees
     */
    public function removeClassifiedtree(\Darkish\CategoryBundle\Entity\ClassifiedClassifiedTree $classifiedtrees)
    {
        $this->classifiedtrees->removeElement($classifiedtrees);
    }

    /**
     * Get classifiedtrees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClassifiedtrees()
    {
        return $this->classifiedtrees;
    }

    /**
     * Set visitCount
     *
     * @param integer $visitCount
     * @return Classified
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
     * @return Classified
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
     * Set price
     *
     * @param integer $price
     *
     * @return Classified
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set claimType
     *
     * @param \Darkish\CategoryBundle\Entity\ClassifiedClaimTypes $claimType
     *
     * @return Classified
     */
    public function setClaimType($claimType = null)
    {
        $this->claimType = $claimType;

        return $this;
    }

    /**
     * Get claimType
     *
     * @return \Darkish\CategoryBundle\Entity\ClassifiedClaimTypes
     */
    public function getClaimType()
    {
        return $this->claimType;
    }

    /**
     * Set webBody
     *
     * @param string $webBody
     *
     * @return Classified
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
