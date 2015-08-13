<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * ContractType
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ContractType
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"api.details","estatecontract.list", "estatecontract.details"})
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="integer")
     * @Groups({"api.details","estatecontract.list", "estatecontract.details"})
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string", length=255)
     * @Groups({"api.details","estatecontract.list", "estatecontract.details"})
     */
    private $value;

    /**
     * @var integer
     *
     * @ORM\Column(name="parentId", type="integer")
     * @Groups({"api.details","estatecontract.list", "estatecontract.details"})
     */
    private $parentId;

    /**
     * @var integer
     *
     * @ORM\Column(name="sort", type="integer", nullable=true)
     * @Groups({"api.details","estatecontract.list", "estatecontract.details"})
     */
    private $sort;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visible", type="boolean")
     * @Groups({"api.details","estatecontract.list", "estatecontract.details"})
     */
    private $visible;


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
     * Set type
     *
     * @param integer $type
     * @return ContractType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set value
     *
     * @param string $value
     * @return ContractType
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     * @return ContractType
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set sort
     *
     * @param integer $sort
     * @return ContractType
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
     * Set visible
     *
     * @param boolean $visible
     * @return ContractType
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;

        return $this;
    }

    /**
     * Get visible
     *
     * @return boolean 
     */
    public function getVisible()
    {
        return $this->visible;
    }
}
