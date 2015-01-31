<?php

namespace Darkish\UserBundle\Entity;

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
 * @ORM\Table(name="role")
 * @ORM\Entity
 */
class Role implements RoleInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"operator.list", "operator.details", "role.list"})
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30)
     * @Groups({"operator.list", "operator.details", "role.list"})
     */
    private $name;

    /**
     * @ORM\Column(name="role", type="string", length=20, unique=true)
     * @Groups({"operator.list", "operator.details"})
     */
    private $role;

    /**
     * @ORM\ManyToMany(targetEntity="Operator", mappedBy="roles")
     */
    private $operators;

    public function __construct()
    {
        $this->operators = new ArrayCollection();
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
     * Add operators
     *
     * @param \Darkish\UserBundle\Entity\Operator $operators
     * @return Role
     */
    public function addOperator(\Darkish\UserBundle\Entity\Operator $operators)
    {
        $this->operators[] = $operators;

        return $this;
    }

    /**
     * Remove operators
     *
     * @param \Darkish\UserBundle\Entity\Operator $operators
     */
    public function removeOperator(\Darkish\UserBundle\Entity\Operator $operators)
    {
        $this->operators->removeElement($operators);
    }

    /**
     * Get operators
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOperators()
    {
        return $this->operators;
    }
}
