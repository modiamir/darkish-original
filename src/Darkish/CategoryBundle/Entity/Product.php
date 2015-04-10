<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"product.list", "product.details"})
     */
    private $id;

    /**
     * @ORM\Column(name="code", type="string")
     * @Groups({"product.list", "product.details"})
     */
    private $code;

    /**
     * @ORM\Column(name="title", type="string")
     * @Groups({"product.list", "product.details"})
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="StoreGroup")
     * @Groups({"product.list", "product.details"})
     */
    private $group;

    /**
     * @ORM\Column(name="sort", type="integer", options={"default" = 0})
     * @Groups({"product.list", "product.details"})
     */
    private $sort = 0;

    /**
     * @ORM\Column(name="special_sort", type="string")
     * @Groups({"product.list", "product.details"})
     */
    private $specialText;

    /**
     * @ORM\Column(name="description", type="text")
     * @Groups({"product.list", "product.details"})
     */
    private $description;

    /**
     * @ORM\Column(name="price", type="bigint")
     * @Groups({"product.list", "product.details"})
     */
    private $price;

    /**
     * @ORM\Column(name="discount_percent", type="smallint")
     * @Groups({"product.list", "product.details"})
     */
    private $discountPercent;

    /**
     * @ORM\Column(name="availability", type="smallint")
     * @Groups({"product.list", "product.details"})
     */
    private $availability;

    /**
     * @ORM\Column(name="special_tag", type="smallint")
     * @Groups({"product.list", "product.details"})
     */
    private $specialTag;    

    /**
     * @ORM\ManyToOne(targetEntity="Record")
     */
    private $record;

    /**
     * @ORM\ManyToOne(targetEntity="\Darkish\CustomerBundle\Entity\Customer")
     * @Groups({"product.list", "product.details"})
     */
    private $customer;

    /**
     * @ORM\Column(name="status", type="boolean")
     * @Groups({"product.list", "product.details"})
     */
    private $status;

    /**
     * @ORM\Column(name="created", type="datetime")
     * @Groups({"product.list", "product.details"})
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="ManagedFile")
     * @Groups({"product.list", "product.details"})
     */
    private $firstPhoto;

    /**
     * @ORM\ManyToOne(targetEntity="ManagedFile")
     * @Groups({"product.list", "product.details"})
     */
    private $secondPhoto;

    /**
     * @ORM\ManyToOne(targetEntity="ManagedFile")
     * @Groups({"product.list", "product.details"})
     */
    private $thirdPhoto;












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
     * Set code
     *
     * @param string $code
     * @return Product
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Product
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
     * Set sort
     *
     * @param integer $sort
     * @return Product
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return integer 
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Set specialText
     *
     * @param string $specialText
     * @return Product
     */
    public function setSpecialText($specialText)
    {
        $this->specialText = $specialText;

        return $this;
    }

    /**
     * Get specialText
     *
     * @return string 
     */
    public function getSpecialText()
    {
        return $this->specialText;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Product
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
     * Set discountPercent
     *
     * @param integer $discountPercent
     * @return Product
     */
    public function setDiscountPercent($discountPercent)
    {
        $this->discountPercent = $discountPercent;

        return $this;
    }

    /**
     * Get discountPercent
     *
     * @return integer 
     */
    public function getDiscountPercent()
    {
        return $this->discountPercent;
    }

    /**
     * Set availability
     *
     * @param integer $availability
     * @return Product
     */
    public function setAvailability($availability)
    {
        $this->availability = $availability;

        return $this;
    }

    /**
     * Get availability
     *
     * @return integer 
     */
    public function getAvailability()
    {
        return $this->availability;
    }

    /**
     * Set specialTag
     *
     * @param integer $specialTag
     * @return Product
     */
    public function setSpecialTag($specialTag)
    {
        $this->specialTag = $specialTag;

        return $this;
    }

    /**
     * Get specialTag
     *
     * @return integer 
     */
    public function getSpecialTag()
    {
        return $this->specialTag;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Product
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
     * Set created
     *
     * @param \DateTime $created
     * @return Product
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
     * Set group
     *
     * @param \Darkish\CategoryBundle\Entity\StoreGroup $group
     * @return Product
     */
    public function setGroup(\Darkish\CategoryBundle\Entity\StoreGroup $group = null)
    {
        $this->group = $group;

        return $this;
    }

    /**
     * Get group
     *
     * @return \Darkish\CategoryBundle\Entity\StoreGroup 
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set record
     *
     * @param \Darkish\CategoryBundle\Entity\Record $record
     * @return Product
     */
    public function setRecord(\Darkish\CategoryBundle\Entity\Record $record = null)
    {
        $this->record = $record;

        return $this;
    }

    /**
     * Get record
     *
     * @return \Darkish\CategoryBundle\Entity\Record 
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * Set customer
     *
     * @param \Darkish\CustomerBundle\Entity\Customer $customer
     * @return Product
     */
    public function setCustomer(\Darkish\CustomerBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Darkish\CustomerBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Set firstPhoto
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $firstPhoto
     * @return Product
     */
    public function setFirstPhoto(\Darkish\CategoryBundle\Entity\ManagedFile $firstPhoto = null)
    {
        $this->firstPhoto = $firstPhoto;

        return $this;
    }

    /**
     * Get firstPhoto
     *
     * @return \Darkish\CategoryBundle\Entity\ManagedFile 
     */
    public function getFirstPhoto()
    {
        return $this->firstPhoto;
    }

    /**
     * Set secondPhoto
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $secondPhoto
     * @return Product
     */
    public function setSecondPhoto(\Darkish\CategoryBundle\Entity\ManagedFile $secondPhoto = null)
    {
        $this->secondPhoto = $secondPhoto;

        return $this;
    }

    /**
     * Get secondPhoto
     *
     * @return \Darkish\CategoryBundle\Entity\ManagedFile 
     */
    public function getSecondPhoto()
    {
        return $this->secondPhoto;
    }

    /**
     * Set thirdPhoto
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $thirdPhoto
     * @return Product
     */
    public function setThirdPhoto(\Darkish\CategoryBundle\Entity\ManagedFile $thirdPhoto = null)
    {
        $this->thirdPhoto = $thirdPhoto;

        return $this;
    }

    /**
     * Get thirdPhoto
     *
     * @return \Darkish\CategoryBundle\Entity\ManagedFile 
     */
    public function getThirdPhoto()
    {
        return $this->thirdPhoto;
    }
}
