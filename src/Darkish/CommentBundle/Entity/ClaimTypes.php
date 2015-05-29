<?php

namespace Darkish\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClaimTypes
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ClaimTypes
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
     * @ORM\Column(name="label", type="string", length=255)
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(name="only_customer", type="boolean", length=255, nullable=true, options={"default" = false})
     */
    private $onlyCustomer;




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
     * Set label
     *
     * @param string $label
     * @return ClaimTypes
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get label
     *
     * @return string 
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Set onlyCustomer
     *
     * @param boolean $onlyCustomer
     * @return ClaimTypes
     */
    public function setOnlyCustomer($onlyCustomer)
    {
        $this->onlyCustomer = $onlyCustomer;

        return $this;
    }

    /**
     * Get onlyCustomer
     *
     * @return boolean 
     */
    public function getOnlyCustomer()
    {
        return $this->onlyCustomer;
    }
}
