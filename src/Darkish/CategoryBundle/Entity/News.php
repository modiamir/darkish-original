<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity(repositoryClass="Darkish\CategoryBundle\Entity\NewsRepository")
 */
class News
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"news.list", "news.details", "comment.details", "comment.list", "api.list"})
     */
    private $id;

    


    /**
     * @var string
     * @ORM\Column(name="Title", type="string", length=255)
     * @Groups({"news.list", "news.details", "comment.details", "comment.list", "api.list"})
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
     * @Groups({"news.list", "news.details", "api.list"})
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
     * @Groups({"news.details"})
     */
    private $creationDate;
    
    
    
    

    /**
     * @var string
     *
     * @ORM\Column(name="LastUpdate", type="datetime", nullable=false)
     * @Groups({"news.details"})
     */
    private $lastUpdate;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="HtmlLastUpdate", type="datetime", nullable=false)
     * @Groups({"news.details"})
     */
    private $htmlLastUpdate;

    /**
     * @var datetime
     *
     * @ORM\Column(name="PublishDate", type="datetime", nullable=true)
     * @Groups({"news.details", "api.list"})
     */
    private $publishDate;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="ExpireDate", type="datetime", nullable=true)
     * @Groups({"news.details"})
     */
    private $expireDate;
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="Continual", type="boolean", nullable=true, options={"default":0})
     * @Groups({"news.details"}) 
     */
    private $continual;
    
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="Immediate", type="boolean", nullable=true, options={"default":0})
     * @Groups({"news.details"}) 
     */
    private $immediate;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="ListRank", type="integer", nullable=true)
     * @Groups({"news.details"})
     */
    private $listRank;
    
    
    /**
     *
     * @var boolean
     * 
     * @ORM\Column(name="IsCompetition", type="boolean", nullable=true, options={"default":0})
     * @Groups({"news.details"}) 
     */
    private $isCompetition;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="TrueAnswer", type="integer", nullable=true)
     * @Groups({"news.details"})
     */
    private $trueAnswer;
    
    /**
     *
     * @var integer
     * 
     * @ORM\Column(name="Rate", type="integer", nullable=true)
     * @Groups({"news.details"})
     */
    private $rate;
    

    /**
     * @var boolean
     *
     * @ORM\Column(name="Commentable", type="boolean", nullable=false, options={"default":1})
     * @Groups({"news.details", "news.list", "api.list"})
     */
    private $commentable;


    /**
     * @var string
     *
     * @ORM\Column(name="CommentDefaultState", type="integer", nullable=false, options={"default":3})
     * @Groups({"news.details"})
     */
    private $commentDefaultState;
    

    /**
     * @var string
     *
     * @ORM\Column(name="Body", type="text", nullable=true)
     * @Groups({"news.details", "api.body"})
     */
    private $body;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Audio", type="boolean", nullable=true, options={"default"=false})
     * @Groups({"news.details", "api.list"})
     */
    private $audio;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Video", type="boolean", nullable=true, options={"default"=false})
     * @Groups({"news.details", "api.list"})
     */
    private $video;

    /**
     * @ORM\Column(name="VisitCount", type="integer", nullable=true, options={"default"=0})
     * @Groups({"news.details", "api.list"})
     */
    private $visitCount;

    /**
     * @ORM\Column(name="LikeCount", type="integer", nullable=true, options={"default"=0})
     * @Groups({"news.details", "api.list"})
     */
    private $likeCount;


    /**
     * @ORM\Column(name="CommentCount", type="integer", nullable=true, options={"default"=0})
     * @Groups({"news.details", "api.list"})
     */
    private $commentCount;
    

    /**
     * @var boolean
     *
     * @ORM\Column(name="Active", type="boolean", nullable=false, options={"default":0})
     * @Groups({"news.details"})
     */
    private $active;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Verify", type="boolean", nullable=false, options={"default": 0})
     * @Groups({"news.details"})
     */
    private $verify;

    
    
    

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $trees
     *
     * @Groups({"news.details"})
     *
     * @ORM\ManyToMany(targetEntity="Darkish\CategoryBundle\Entity\NewsTree", inversedBy="news")
     * @ORM\JoinTable(name="news_newstrees",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="newstree_id", referencedColumnName="id", onDelete="CASCADE")}
     *      )
     **/
    private $trees;


    /**
     * @ORM\OneToMany(targetEntity="NewsNewsTree", mappedBy="news")
     * @Groups({"news.details", "api.list"})
     **/
    private $newstrees;


    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="news_images",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"news.details", "api.list"})
     **/
    private $images;
    
    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ManagedFile", inversedBy="iconForNews")
     * @ORM\JoinColumn(name="IconIndex", referencedColumnName="id")
     * @Groups({"news.details", "api.list"})
     * 
     **/
    private $icon;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="news_body_images",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"news.details"})
     **/
    private $bodyImages;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="news_videos",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"news.details"})
     **/
    private $videos;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="news_body_videos",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"news.details"})
     **/
    private $bodyVideos;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="news_audios",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"news.details"})
     **/
    private $audios;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="news_body_audios",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"news.details"})
     **/
    private $bodyAudios;
    
    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="news_body_docs",
     *      joinColumns={@ORM\JoinColumn(name="news_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id", unique=true)}
     *      )
     * @Groups({"news.details"})
     **/
    private $bodyDocs;


    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="\Darkish\UserBundle\Entity\Operator", inversedBy="news")
     * @ORM\JoinColumn(name="UserId", referencedColumnName="id")
     * @Groups({"news.details"})
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="\Darkish\CommentBundle\Entity\NewsThread", mappedBy="target")
     * @Exclude
     */
    private $thread;



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
     * @return News
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
     * @return News
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
     * @return News
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
     * @param \Darkish\CategoryBundle\Entity\NewsTree $trees
     * @return News
     */
    public function addTree(\Darkish\CategoryBundle\Entity\NewsTree $tree)
    {
        $this->trees[] = $tree;

        return $this;
    }

    /**
     * Remove tree
     *
     * @param \Darkish\CategoryBundle\Entity\NewsTree $tree
     */
    public function removeTree(\Darkish\CategoryBundle\Entity\NewsTree $tree)
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * @return News
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
     * Add newstrees
     *
     * @param \Darkish\CategoryBundle\Entity\NewsNewsTree $newstrees
     * @return News
     */
    public function addNewstree(\Darkish\CategoryBundle\Entity\NewsNewsTree $newstrees)
    {
        $this->newstrees[] = $newstrees;

        return $this;
    }

    /**
     * Remove newstrees
     *
     * @param \Darkish\CategoryBundle\Entity\NewsNewsTree $newstrees
     */
    public function removeNewstree(\Darkish\CategoryBundle\Entity\NewsNewsTree $newstrees)
    {
        $this->newstrees->removeElement($newstrees);
    }

    /**
     * Get newstrees
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNewstrees()
    {
        return $this->newstrees;
    }

    /**
     * Set thread
     *
     * @param \Darkish\CommentBundle\Entity\NewsThread $thread
     * @return News
     */
    public function setThread(\Darkish\CommentBundle\Entity\NewsThread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Darkish\CommentBundle\Entity\NewsThread 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set commentable
     *
     * @param boolean $commentable
     * @return News
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
     * Set commentDefaultState
     *
     * @param integer $commentDefaultState
     * @return News
     */
    public function setCommentDefaultState($commentDefaultState)
    {
        $this->commentDefaultState = $commentDefaultState;

        return $this;
    }

    /**
     * Get commentDefaultState
     *
     * @return integer 
     */
    public function getCommentDefaultState()
    {
        return $this->commentDefaultState;
    }

    /**
     * Set visitCount
     *
     * @param integer $visitCount
     * @return News
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
     * @return News
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
     * Set commentCount
     *
     * @param integer $commentCount
     * @return News
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
}
