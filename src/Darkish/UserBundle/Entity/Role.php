<?php

namespace Darkish\UserBundle\Entity;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(name="role", type="string", length=20, unique=true)
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
