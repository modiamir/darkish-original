<?php

namespace Darkish\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserLog
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UserLog
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="operation", type="string", length=255)
     */
    private $operation;
    
    /**
     * @ORM\ManyToOne(targetEntity="Operator", inversedBy="logs")
     * @ORM\JoinColumn(name="operator_id", referencedColumnName="id")
     */
    private $operator;


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
     * Set date
     *
     * @param \DateTime $date
     * @return UserLog
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set operation
     *
     * @param string $operation
     * @return UserLog
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;

        return $this;
    }

    /**
     * Get operation
     *
     * @return string 
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     * Set operator
     *
     * @param \Darkish\UserBundle\Entity\Operator $operator
     * @return OperatorLog
     */
    public function setOperator(\Darkish\UserBundle\Entity\Operator $operator = null)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Get operator
     *
     * @return \Darkish\UserBundle\Entity\Operator 
     */
    public function getOperator()
    {
        return $this->operator;
    }
}
