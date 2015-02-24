<?php

namespace Darkish\CustomerBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * Role
 *
 * @ORM\Table(name="customer_role")
 * @ORM\Entity
 */
class CustomerRole implements RoleInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"customer.list", "customer.details", "role.list"})
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30)
     * @Groups({"customer.list", "customer.details", "role.list"})
     */
    private $name;

    /**
     * @ORM\Column(name="role", type="string", length=30, unique=true)
     * @Groups({"customer.list", "customer.details", "role.list"})
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="Customer", mappedBy="assistantAccess")
     */
    private $assistants;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }

    /**
     * @see RoleInterface
     */
    public function getRole()
    {
        return $this->role;
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
     * Set name
     *
     * @param string $name
     * @return Role
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
     * Set role
     *
     * @param string $role
     * @return Role
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Add customers
     *
     * @param \Darkish\CustomerBundle\Entity\Customer $customers
     * @return Role
     */
    public function addCustomer(\Darkish\CustomerBundle\Entity\Customer $customers)
    {
        $this->customers[] = $customers;

        return $this;
    }

    /**
     * Remove customers
     *
     * @param \Darkish\CustomerBundle\Entity\Customer $customers
     */
    public function removeCustomer(\Darkish\CustomerBundle\Entity\Customer $customers)
    {
        $this->customers->removeElement($customers);
    }

    /**
     * Get customers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCustomers()
    {
        return $this->customers;
    }
}
