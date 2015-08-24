<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\Type;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"code", "record"},
 *     errorPath="code",
 *     message="This code is already in use on that record."
 * )
 */
class Product
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $id;

    /**
     * @ORM\Column(name="code", type="string")
     * @Groups({"product.list", "product.details", "api.list"})
     * @Type("integer")
     */
    private $code;

    /**
     * @ORM\Column(name="title", type="string")
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="StoreGroup")
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $group;

    /**
     * @ORM\Column(name="sort", type="integer", options={"default" = 0})
     * @Groups({"product.list", "product.details", "api.list"})
     * @Type("integer")
     */
    private $sort = 0;

    /**
     * @ORM\Column(name="special_text", type="string", nullable= true)
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $specialText;

    /**
     * @ORM\Column(name="description", type="text", nullable= true)
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $description;

    /**
     * @ORM\Column(name="price", type="bigint")
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $price;

    /**
     * @ORM\Column(name="discounted_price", type="bigint", nullable= true)
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $discountedPrice;

    /**
     * @ORM\Column(name="availability", type="smallint")
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $availability;

    /**
     * @ORM\Column(name="special_tag", type="smallint")
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $specialTag;    

    /**
     * @ORM\ManyToOne(targetEntity="Record", inversedBy="products")
     */
    private $record;

    /**
     * @ORM\ManyToOne(targetEntity="\Darkish\CustomerBundle\Entity\Customer")
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $customer;

    /**
     * @ORM\Column(name="status", type="boolean")
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $status;

    /**
     * @ORM\Column(name="created", type="datetime")
     * @Groups({"product.list", "product.details", "api.list"})
     */
    private $created;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="product_photos",
     *      joinColumns={@ORM\JoinColumn(name="product_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id")}
     *      )
     * @Groups({"product.list", "product.details", "api.list"})
     **/
    private $photos;


    




    



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
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->availability = 1;
        $this->specialTag = 1;
    }

    /**
     * Add photos
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $photos
     * @return Product
     */
    public function addPhoto(\Darkish\CategoryBundle\Entity\ManagedFile $photos)
    {
        $this->photos[] = $photos;

        return $this;
    }

    /**
     * Remove photos
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $photos
     */
    public function removePhoto(\Darkish\CategoryBundle\Entity\ManagedFile $photos)
    {
        $this->photos->removeElement($photos);
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
     * @VirtualProperty
     * @Groups({"product.details", "product.list"})
     */
    public function getGroupId() {
        if(!$this->group) {
            return 0;
        } else {
            return $this->group->getId();
        }
    }

    /**
     * Set discountedPrice
     *
     * @param integer $discountedPrice
     * @return Product
     */
    public function setDiscountedPrice($discountedPrice)
    {
        $this->discountedPrice = $discountedPrice;

        return $this;
    }

    /**
     * Get discountedPrice
     *
     * @return integer 
     */
    public function getDiscountedPrice()
    {
        return $this->discountedPrice;
    }
}
