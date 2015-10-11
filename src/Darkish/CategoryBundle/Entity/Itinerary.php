<?php

namespace Darkish\CategoryBundle\Entity;

use Darkish\CategoryBundle\Interfaces\ClaimableInterface;
use Darkish\CategoryBundle\Interfaces\LikableInterface;
use Darkish\CategoryBundle\Interfaces\VisitableInterface;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Itinerary
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\DiscriminatorColumn("type")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({"client" = "ClientItinerary", "anonymous" = "AnonymousItinerary", "itinerary" = "Itinerary"})
 */
class Itinerary implements LikableInterface, VisitableInterface, ClaimableInterface
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"itinerary.list.api"})
     */
    protected $id;

    /**
     * @var string
     * @Assert\Length(
     *      max = 100,
     * )
     * @Assert\NotNull()
     * @ORM\Column(name="title", type="string", length=255)
     * @Groups({"itinerary.list.api"})
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(name="full_name", type="string", length=255)
     * @Assert\Length(
     *      max = 50,
     * )
     * @Assert\NotNull()
     * @Groups({"itinerary.list.api"})
     */
    protected $fullName;

    /**
     * @var string
     * @Assert\Length(
     *      max = 5000,
     * )
     * @Assert\NotNull()
     * @ORM\Column(name="body", type="text", nullable=true)
     * @Groups({"itinerary.list.api"})
     */
    protected $body;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile", cascade={"persist"})
     * @ORM\JoinTable(name="itinerary_photos",
     *      joinColumns={@ORM\JoinColumn(name="itinerary_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id")}
     *      )
     * @Assert\Count(
     *      max = "5",
     *      maxMessage = "تعداد تصاویر بیش از حد مجاز است."
     * )
     * @Groups({"itinerary.list.api"})
     **/
    protected $photos;

    /**
     * @var
     * @ORM\Column(name="created", type="datetime")
     * @Groups({"itinerary.list.api"})
     */
    protected $created;

    /**
     * @var integer
     * @ORM\Column(name="visit_count", type="integer", options={"default"=0}, nullable=true)
     * @Groups({"itinerary.list.api"})
     */
    protected $visitCount = 0;

    /**
     * @var integer
     * @ORM\Column(name="comment_count", type="integer", options={"default"=0}, nullable=true)
     * @Groups({"itinerary.list.api"})
     */
    protected $commentCount = 0 ;

    /**
     * @var integer
     * @ORM\Column(name="like_count", type="integer", options={"default"=0}, nullable=true)
     * @Groups({"itinerary.list.api"})
     */
    protected $likeCount = 0;

    /**
     * @ORM\OneToOne(targetEntity="\Darkish\CommentBundle\Entity\ItineraryThread", mappedBy="target")
     */
    protected $thread;

    /**
     * @ORM\Column(name="claim_type", type="integer", nullable=true)
     * @Groups({"comment.details"})
     */
    protected $claimType;

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
     * Set thread
     *
     * @param \Darkish\CommentBundle\Entity\ItineraryThread $thread
     * @return Itinerary
     */
    public function setThread(\Darkish\CommentBundle\Entity\ItineraryThread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Darkish\CommentBundle\Entity\ItineraryThread
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Itinerary
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
     * Set body
     *
     * @param string $body
     *
     * @return Itinerary
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
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setPhotos(\Doctrine\Common\Collections\ArrayCollection $photos)
    {
        $this->photos = $photos;
    }

    /**
     * Add photo
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $photo
     *
     * @return Itinerary
     */
    public function addPhoto(\Darkish\CategoryBundle\Entity\ManagedFile $photo)
    {
        $this->photos[] = $photo;

        return $this;
    }

    /**
     * Remove photo
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $photo
     */
    public function removePhoto(\Darkish\CategoryBundle\Entity\ManagedFile $photo)
    {
        $this->photos->removeElement($photo);
    }

    /**
     * Get photos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Itinerary
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return Itinerary
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set visitCount
     *
     * @param integer $visitCount
     *
     * @return Itinerary
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
     * Set commentCount
     *
     * @param integer $commentCount
     *
     * @return Itinerary
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
     * Set likeCount
     *
     * @param integer $likeCount
     *
     * @return Itinerary
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
     * Set claimType
     *
     * @param integer $claimType
     *
     * @return Itinerary
     */
    public function setClaimType($claimType = null)
    {
        $this->claimType = $claimType;

        return $this;
    }

    /**
     * Get claimType
     *
     * @return integer
     */
    public function getClaimType()
    {
        return $this->claimType;
    }
}
