<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use VMelnik\DoctrineEncryptBundle\Configuration\Encrypted;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * RecordRegisterCode
 *
 * @ORM\Table()
 * @ORM\Entity
 * @UniqueEntity("email")
 */
class RecordRegisterCode
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
     * @ORM\Column(name="recordNumber", type="string", length=255, unique=true)
     */
    private $recordNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=255)
     * @Encrypted
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Encrypted
     */
    private $password;

    /**
     * @var boolean
     *
     * @ORM\Column(name="used", type="boolean")
     */
    private $used;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var boolean
     *
     * @ORM\Column(name="printed", type="boolean", options={"defaults" = false})
     */
    private $printed = false;

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
     * Set recordNumber
     *
     * @param string $recordNumber
     *
     * @return RecordRegisterCode
     */
    public function setRecordNumber($recordNumber)
    {
        $this->recordNumber = $recordNumber;

        return $this;
    }

    /**
     * Get recordNumber
     *
     * @return string
     */
    public function getRecordNumber()
    {
        return $this->recordNumber;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return RecordRegisterCode
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return RecordRegisterCode
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set used
     *
     * @param boolean $used
     *
     * @return RecordRegisterCode
     */
    public function setUsed($used)
    {
        $this->used = $used;

        return $this;
    }

    /**
     * Get used
     *
     * @return boolean
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return RecordRegisterCode
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
     * Set printed
     *
     * @param boolean $printed
     *
     * @return RecordRegisterCode
     */
    public function setPrinted($printed)
    {
        $this->printed = $printed;

        return $this;
    }

    /**
     * Get printed
     *
     * @return boolean
     */
    public function getPrinted()
    {
        return $this->printed;
    }
}
