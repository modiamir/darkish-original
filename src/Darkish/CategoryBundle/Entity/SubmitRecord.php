<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Misd\PhoneNumberBundle\Doctrine\DBAL\Types\PhoneNumberType;

/**
 * SubmitRecord
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SubmitRecord
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
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="phone_number", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="phone_number", length=255)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="licenseNumber", type="string", length=255, nullable=true)
     */
    private $licenseNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="companyName", type="string", length=255, nullable=true)
     */
    private $companyName;

    /**
     * @var string
     *
     * @ORM\Column(name="companyRegNumber", type="string", length=255, nullable=true)
     */
    private $companyRegNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="companyRegDate", type="string", nullable=true)
     */
    private $companyRegDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="reviewed", type="boolean", options={"default"=false})
     */
    private $reviewed = false;


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
     * Set firstName
     *
     * @param string $firstName
     *
     * @return SubmitRecord
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return SubmitRecord
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return SubmitRecord
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     *
     * @return SubmitRecord
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return SubmitRecord
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
     *
     * @return SubmitRecord
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
     * Set email
     *
     * @param string $email
     *
     * @return SubmitRecord
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set licenseNumber
     *
     * @param string $licenseNumber
     *
     * @return SubmitRecord
     */
    public function setLicenseNumber($licenseNumber)
    {
        $this->licenseNumber = $licenseNumber;

        return $this;
    }

    /**
     * Get licenseNumber
     *
     * @return string
     */
    public function getLicenseNumber()
    {
        return $this->licenseNumber;
    }

    /**
     * Set companyName
     *
     * @param string $companyName
     *
     * @return SubmitRecord
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set companyRegNumber
     *
     * @param string $companyRegNumber
     *
     * @return SubmitRecord
     */
    public function setCompanyRegNumber($companyRegNumber)
    {
        $this->companyRegNumber = $companyRegNumber;

        return $this;
    }

    /**
     * Get companyRegNumber
     *
     * @return string
     */
    public function getCompanyRegNumber()
    {
        return $this->companyRegNumber;
    }

    

    /**
     * Set reviewed
     *
     * @param boolean $reviewed
     *
     * @return SubmitRecord
     */
    public function setReviewed($reviewed)
    {
        $this->reviewed = $reviewed;

        return $this;
    }

    /**
     * Get reviewed
     *
     * @return boolean
     */
    public function getReviewed()
    {
        return $this->reviewed;
    }

    /**
     * Set companyRegDate
     *
     * @param string $companyRegDate
     *
     * @return SubmitRecord
     */
    public function setCompanyRegDate($companyRegDate)
    {
        $this->companyRegDate = $companyRegDate;

        return $this;
    }

    /**
     * Get companyRegDate
     *
     * @return string
     */
    public function getCompanyRegDate()
    {
        return $this->companyRegDate;
    }
}
