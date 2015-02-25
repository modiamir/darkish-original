<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\ExecutionContextInterface;
/**
 * News
 *
 * @ORM\Table(name="classified")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Classified
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;



    /**
     * @var \DateTime
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="created_date", type="datetimetz", nullable=true)
     */
    private $createdDate;


    /**
     * @var integer
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="publish_date", type="integer", nullable=true)
     */
    private $publishDate;

    /**
     * @var integer
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(name="expire_date", type="integer", nullable=true)
     */
    private $expireDate;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var integer
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @var boolean
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(name="status", type="boolean", nullable=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", nullable=true)
     *
     */
    private $category;


    /**
     * @var integer
     *
     * @ORM\Column(name="classifiedtree_id", type="integer", nullable=true)
     */
    private $classifiedtreeId;


    /**
     * @var string
     *
     * @ORM\Column(name="first_phone", type="string", nullable=true)
     *
     */
    private $firstPhone;


    /**
     * @var string
     *
     * @ORM\Column(name="second_phone", type="string", nullable=true)
     *
     */
    private $secondPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", nullable=true)
     *
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="unit_number", type="string", nullable=true)
     *
     */
    private $unitNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="first_image", type="string", nullable=true)
     *
     */
    private $firstImage;

    /**
     * @var string
     *
     * @ORM\Column(name="second_image", type="string", nullable=true)
     *
     */
    private $secondImage;

    /**
     * @var string
     *
     * @ORM\Column(name="third_image", type="string", nullable=true)
     *
     */
    private $thirdImage;

    /**
     * @var string
     *
     * @ORM\Column(name="banner", type="string", nullable=true)
     *
     */
    private $banner;

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
     * Set createdDate
     *
     * @param \DateTime $createdDate
     * @return News
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return integer
     */
    public function getCreatedDate()
    {
        /* @var $this->createdDate DateTime */
        if($this->createdDate) {
            return $this->createdDate->getTimestamp();
        }

    }


    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDateObject()
    {
        return $this->createdDate;
    }


    /**
     * Set expireDate
     *
     * @param integer $expireDate
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
     * @return integer 
     */
    public function getExpireDate()
    {
        return $this->expireDate;
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
     * Set userId
     *
     * @param integer $userId
     * @return News
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
     * Set status
     *
     * @param boolean $status
     * @return News
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
     * Set category
     *
     * @param string $category
     * @return News
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set newstreeId
     *
     * @param integer $newstreeId
     * @return News
     */
    public function setClassifiedtreeId($classifiedtreeId)
    {
        $this->classifiedtreeId = $classifiedtreeId;

        return $this;
    }

    /**
     * Get newstreeId
     *
     * @return integer 
     */
    public function getClassifiedtreeId()
    {
        return $this->classifiedtreeId;
    }



    /**
     * Set publishDate
     *
     * @param integer $publishDate
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
     * @return integer 
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set firstPhone
     *
     * @param string $firstPhone
     * @return Classified
     */
    public function setFirstPhone($firstPhone)
    {
        $this->firstPhone = $firstPhone;

        return $this;
    }

    /**
     * Get firstPhone
     *
     * @return string 
     */
    public function getFirstPhone()
    {
        return $this->firstPhone;
    }

    /**
     * Set secondPhone
     *
     * @param string $secondPhone
     * @return Classified
     */
    public function setSecondPhone($secondPhone)
    {
        $this->secondPhone = $secondPhone;

        return $this;
    }

    /**
     * Get secondPhone
     *
     * @return string 
     */
    public function getSecondPhone()
    {
        return $this->secondPhone;
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
     * Set unitNumber
     *
     * @param string $unitNumber
     * @return Classified
     */
    public function setUnitNumber($unitNumber)
    {
        $this->unitNumber = $unitNumber;

        return $this;
    }

    /**
     * Get unitNumber
     *
     * @return string 
     */
    public function getUnitNumber()
    {
        return $this->unitNumber;
    }

    /**
     * Set firstImage
     *
     * @param string $firstImage
     * @return Classified
     */
    public function setFirstImage($firstImage)
    {
        $this->firstImage = $firstImage;

        return $this;
    }

    /**
     * Get firstImage
     *
     * @return string 
     */
    public function getFirstImage()
    {
        return $this->firstImage;
    }

    /**
     * Set secondImage
     *
     * @param string $secondImage
     * @return Classified
     */
    public function setSecondImage($secondImage)
    {
        $this->secondImage = $secondImage;

        return $this;
    }

    /**
     * Get secondImage
     *
     * @return string 
     */
    public function getSecondImage()
    {
        return $this->secondImage;
    }

    /**
     * Set thirdImage
     *
     * @param string $thirdImage
     * @return Classified
     */
    public function setThirdImage($thirdImage)
    {
        $this->thirdImage = $thirdImage;

        return $this;
    }

    /**
     * Get thirdImage
     *
     * @return string 
     */
    public function getThirdImage()
    {
        return $this->thirdImage;
    }

    /**
     * Set banner
     *
     * @param string $banner
     * @return Classified
     */
    public function setBanner($banner)
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * Get banner
     *
     * @return string 
     */
    public function getBanner()
    {
        return $this->banner;
    }
}
