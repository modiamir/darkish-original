<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * RecordAccessLevel
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RecordAccessLevel
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"record.list", "record.details", "recordaccess.list", "recordaccess.details", "customer.details", "customer.list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"record.list", "record.details", "recordaccess.list", "recordaccess.details", "customer.details", "customer.list"})
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="\Darkish\CustomerBundle\Entity\CustomerRole", inversedBy="recordLevels")
     * @Groups({"recordaccess.list", "recordaccess.details", "customer.list", "customer.details"})
     */
    private $customerRoles;


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
     * Set name
     *
     * @param string $name
     * @return RecordAccessLevel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->customerRoles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add customerRoles
     *
     * @param \Darkish\CustomerBundle\Entity\CustomerRole $customerRoles
     * @return RecordAccessLevel
     */
    public function addCustomerRole(\Darkish\CustomerBundle\Entity\CustomerRole $customerRoles)
    {
        $this->customerRoles[] = $customerRoles;

        return $this;
    }

    /**
     * Remove customerRoles
     *
     * @param \Darkish\CustomerBundle\Entity\CustomerRole $customerRoles
     */
    public function removeCustomerRole(\Darkish\CustomerBundle\Entity\CustomerRole $customerRoles)
    {
        $this->customerRoles->removeElement($customerRoles);
    }

    /**
     * Get customerRoles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCustomerRoles()
    {
        return $this->customerRoles;
    }
}
