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
class Estate extends DBase
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
     * @var string
     * @Groups({"database.list", "database.details"})
     * @Type("integer")
     */
    protected $code;

    /**
     * @var string
     * @Groups({"database.list", "database.details"})
     */
    protected $title;

    /**
     * @var string
     * @Groups({"database.list", "database.details"})
     */
    protected $description;

    /**
     * @var boolean
     * @Groups({"database.list", "database.details"})
     */
    protected $status;

    /**
     * @var \DateTime
     * @Groups({"database.list", "database.details"})
     */
    protected $created;

    /**
     * @var \Darkish\CategoryBundle\Entity\Record
     * @Groups({"database.list", "database.details"})
     */
    protected $record;

    /**
     * @var \Darkish\CustomerBundle\Entity\Customer
     * @Groups({"database.list", "database.details"})
     */
    protected $customer;

    /**
     * @var \Doctrine\Common\Collections\Collection
     * @Groups({"database.list", "database.details"})
     */
    protected $photos;

    /**
     * @var integer
     * @Groups({"database.list", "database.details"})
     */
    protected $price;

    /**
     * @var integer
     * @Groups({"database.list", "database.details"})
     */
    protected $secondaryPrice;
    

    /**
     * @ORM\Column(name="estate_features", type="json_array")
     * @Groups({"database.list", "database.details"})
     **/
    private $estateFeatures;

    /**
     * @ORM\ManyToOne(targetEntity="EstateType")
     * @ORM\JoinColumn("estate_estateType_id")
     * @Groups({"database.list", "database.details"})
     */
    private $estateType;


    /**
     * @ORM\ManyToOne(targetEntity="ContractType")
     * @Groups({"database.list", "database.details"})
     * @ORM\JoinColumn("estate_contractType_id")
     */
    private $contractType;

    /**
     * @ORM\Column(name="estate_dimension", type="integer", nullable=true)
     * @Groups({"database.list", "database.details"})
     */
    private $dimension;

    /**
     * @ORM\Column(name="estate_num_of_rooms", type="smallint", nullable=true)
     * @Groups({"database.list", "database.details"})
     */
    private $numOfRooms;

    /**
     * @ORM\Column(name="estate_floor", type="smallint", nullable=true)
     * @Groups({"database.list", "database.details"})
     */
    private $floor;

    /**
     * @ORM\Column(name="estate_region", type="string", nullable=true)
     * @Groups({"database.list", "database.details"})
     */
    private $region;

    /**
     * @ORM\Column(name="estate_age", type="smallint", nullable=true)
     * @Groups({"database.list", "database.details"})
     */
    private $age;

    


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
     * Set dimension
     *
     * @param integer $dimension
     * @return Estate
     */
    public function setDimension($dimension)
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get dimension
     *
     * @return integer 
     */
    public function getDimension()
    {
        return $this->dimension;
    }

    /**
     * Set numOfRooms
     *
     * @param integer $numOfRooms
     * @return Estate
     */
    public function setNumOfRooms($numOfRooms)
    {
        $this->numOfRooms = $numOfRooms;

        return $this;
    }

    /**
     * Get numOfRooms
     *
     * @return integer 
     */
    public function getNumOfRooms()
    {
        return $this->numOfRooms;
    }

    
    /**
     * Set region
     *
     * @param string $region
     * @return Estate
     */
    public function setRegion($region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return string 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set age
     *
     * @param integer $age
     * @return Estate
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return integer 
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set price
     *
     * @param integer $price
     * @return Estate
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
     * @return Estate
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

    /**
     * Set estateType
     *
     * @param \Darkish\CategoryBundle\Entity\EstateType $estateType
     * @return Estate
     */
    public function setEstateType(\Darkish\CategoryBundle\Entity\EstateType $estateType = null)
    {
        $this->estateType = $estateType;

        return $this;
    }

    /**
     * Get estateType
     *
     * @return \Darkish\CategoryBundle\Entity\EstateType 
     */
    public function getEstateType()
    {
        return $this->estateType;
    }

    /**
     * Set contractType
     *
     * @param \Darkish\CategoryBundle\Entity\ContractType $contractType
     * @return Estate
     */
    public function setContractType(\Darkish\CategoryBundle\Entity\ContractType $contractType = null)
    {
        $this->contractType = $contractType;

        return $this;
    }

    /**
     * Get contractType
     *
     * @return \Darkish\CategoryBundle\Entity\ContractType 
     */
    public function getContractType()
    {
        return $this->contractType;
    }

    

    /**
     * Set floor
     *
     * @param integer $floor
     * @return Estate
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get floor
     *
     * @return integer 
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * Set estateFeatures
     *
     * @param array $estateFeatures
     * @return Estate
     */
    public function setEstateFeatures($estateFeatures)
    {
        $this->estateFeatures = $estateFeatures;

        return $this;
    }

    /**
     * Get estateFeatures
     *
     * @return array 
     */
    public function getEstateFeatures()
    {
        return $this->estateFeatures;
    }
}