<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\ExecutionContextInterface;
use Doctrine\ORM\EntityManager;
/**
 * News
 *
 * @ORM\Table(name="news")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
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
     * @var string
     *
     *
     * @ORM\Column(name="sub_title", type="string", length=255, nullable=true)
     */
    private $subTitle;

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
     * @var boolean
     *
     * @Assert\NotNull()
     *
     * @ORM\Column(name="is_competition", type="boolean", nullable=true)
     */
    private $isCompetition;

    /**
     * @var integer
     *
     * @ORM\Column(name="true_answer", type="integer", nullable=true)
     */
    private $trueAnswer;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="integer", nullable=true)
     */
    private $rate;

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
     * @ORM\Column(name="newstree_id", type="integer", nullable=true)
     */
    private $newstreeId;




    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {
        if( $this->isCompetition == 1  && !$this->trueAnswer ) {
            $context->addViolationAt('trueAnswer', 'Pick a cooler name!');
        }

        if($this->isCompetition == 1 && !$this->rate) {
            $context->addViolationAt('rate', 'Pick a cooler name!');
        }
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
     * Set isCompetition
     *
     * @param boolean $isCompetition
     * @return News
     */
    public function setIsCompetition($isCompetition)
    {
        if($isCompetition == 1) {
            $this->isCompetition = true;
        }
        else {
            $this->isCompetition = false;
        }

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
    public function setNewstreeId($newstreeId)
    {
        $this->newstreeId = $newstreeId;

        return $this;
    }

    /**
     * Get newstreeId
     *
     * @return integer 
     */
    public function getNewstreeId()
    {
        return $this->newstreeId;
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


}
