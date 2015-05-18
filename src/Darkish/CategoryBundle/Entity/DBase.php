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
 * @ORM\Table(name="DBase")
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"estate" = "Estate", "automobile" = "Automobile", "dbase" = "DBase"})
 * @UniqueEntity(
 *     fields={"code", "record"},
 *     errorPath="code",
 *     message="This code is already in use on that record."
 * )
 */
class DBase
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"database.list", "database.details"})
     */
    protected $id;

    /**
     * @ORM\Column(name="code", type="string", nullable=true)
     * @Groups({"database.list", "database.details"})
     * @Type("integer")
     */
    protected $code;

    /**
     * @ORM\Column(name="title", type="string")
     * @Groups({"database.list", "database.details"})
     */
    protected $title;

    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     * @Groups({"database.list", "database.details"})
     */
    protected $description;



    /**
     * @ORM\ManyToOne(targetEntity="Record")
     * @Groups({"database.list", "database.details"})
     */
    protected $record;

    /**
     * @ORM\ManyToOne(targetEntity="\Darkish\CustomerBundle\Entity\Customer")
     * @Groups({"database.list", "database.details"})
     */
    protected $customer;

    /**
     * @ORM\Column(name="status", type="boolean", nullable=true)
     * @Groups({"database.list", "database.details"})
     */
    protected $status;

    /**
     * @ORM\Column(name="created", type="datetime", nullable=true)
     * @Groups({"database.list", "database.details"})
     */
    protected $created;

    /**
     * @ORM\ManyToMany(targetEntity="ManagedFile")
     * @ORM\JoinTable(name="dbase_photos",
     *      joinColumns={@ORM\JoinColumn(name="estate_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="file_id", referencedColumnName="id")}
     *      )
     * @Groups({"database.list", "database.details"})
     **/
    protected $photos;

    /**
     * @ORM\Column(name="price", type="bigint", nullable=true)
     * @Groups({"database.list", "database.details"})
     */
    protected $price;

    /**
     * @ORM\Column(name="secondary_price", type="bigint", nullable=true)
     * @Groups({"database.list", "database.details"})
     */
    protected $secondaryPrice;



    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->photos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set code
     *
     * @param string $code
     * @return DBase
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
     * @return DBase
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
     * Set description
     *
     * @param string $description
     * @return DBase
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
     * Set status
     *
     * @param boolean $status
     * @return DBase
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
     * @return DBase
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
     * Set record
     *
     * @param \Darkish\CategoryBundle\Entity\Record $record
     * @return DBase
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
     * @return DBase
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
     * Add photos
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $photos
     * @return DBase
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
     * Set price
     *
     * @param integer $price
     * @return DBase
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
     * Set secondaryPrice
     *
     * @param integer $secondaryPrice
     * @return DBase
     */
    public function setSecondaryPrice($secondaryPrice)
    {
        $this->secondaryPrice = $secondaryPrice;

        return $this;
    }

    /**
     * Get secondaryPrice
     *
     * @return integer 
     */
    public function getSecondaryPrice()
    {
        return $this->secondaryPrice;
    }
}
