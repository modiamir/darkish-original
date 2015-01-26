<?php

namespace Darkish\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * User
 *
 * @ORM\Table(name="darkish_operators")
 * @ORM\Entity
 */
class Operator implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"operator.list", "operator.details"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Groups({"operator.list", "operator.details"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Groups({"operator.list", "operator.details"})
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @Groups({"operator.list", "operator.details"})
     */
    private $isActive;
    
    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="operators")
     * @Groups({"operator.list", "operator.details"})
     */
    private $roles;
    
    
    /**
     *
     * @ORM\Column(name="first_name", type="string", nullable=true)
     * @Groups({"operator.list", "operator.details"})
     */
    private $firstName;
    
    /**
     *
     * @ORM\Column(name="last_name", type="string", nullable=true)
     * @Groups({"operator.list", "operator.details"})
     */
    private $lastName;
    
    /**
     *
     * @ORM\Column(name="phone", type="string", nullable=true)
     * @Groups({"operator.details"})
     */
    private $phone;
    
    /**
     *
     * @ORM\Column(name="mobile", type="string", nullable=true)
     * @Groups({"operator.details"})
     */
    private $mobile;
        
    /**
     *
     * @ORM\Column(name="secondary_mail", type="string", nullable=true)
     * @Groups({"operator.details"})
     */
    private $secondaryMail;
    
    /**
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     * @Groups({"operator.details"})
     */
    private $created;
    
    /**
     *
     * @ORM\Column(name="access_level", type="integer", nullable=true)
     * @Groups({"operator.details"})
     */
    private $accessLevel;
    
    private $photo;
    
    private $creator;
    
    /**
     * @ORM\OneToMany(targetEntity="\Darkish\CategoryBundle\Entity\Record", mappedBy="user")
     */
    protected $records;
    
    /**
     * @ORM\OneToMany(targetEntity="\Darkish\CategoryBundle\Entity\News", mappedBy="user")
     */
    protected $news;

    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
        
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        /* @var $this->roles \Doctrine\Common\Collections\ArrayCollection() */
        return $this->roles->toArray();
    }
    
    public function getRolesNames() {
        $roles = [];
        /* @var $this->roles \Doctrine\Common\Collections\ArrayCollection() */
        $rolesIterator = $this->roles->getIterator();
        while($rolesIterator->valid()) {
            $roles[] = $rolesIterator->current()->getRole();
            $rolesIterator->next();
        }
        return $roles;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // see section on salt below
            // $this->salt,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    public function isAccountNonExpired()
    {
        return true;
    }

    public function isAccountNonLocked()
    {
        return true;
    }

    public function isCredentialsNonExpired()
    {
        return true;
    }

    public function isEnabled()
    {
        return $this->isActive;
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
     * Set username
     *
     * @param string $username
     * @return Operator
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Operator
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Operator
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
     * Set isActive
     *
     * @param boolean $isActive
     * @return Operator
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Add roles
     *
     * @param \Darkish\UserBundle\Entity\Role $roles
     * @return Operator
     */
    public function addRole(\Darkish\UserBundle\Entity\Role $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Darkish\UserBundle\Entity\Role $roles
     */
    public function removeRole(\Darkish\UserBundle\Entity\Role $roles)
    {
        $this->roles->removeElement($roles);
    }

    

    /**
     * Add records
     *
     * @param \Darkish\CategoryBundle\Entity\Record $records
     * @return Operator
     */
    public function addRecord(\Darkish\CategoryBundle\Entity\Record $records)
    {
        $this->records[] = $records;

        return $this;
    }

    /**
     * Remove records
     *
     * @param \Darkish\CategoryBundle\Entity\Record $records
     */
    public function removeRecord(\Darkish\CategoryBundle\Entity\Record $records)
    {
        $this->records->removeElement($records);
    }

    /**
     * Get records
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecords()
    {
        return $this->records;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     * @return Operator
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
     * @return Operator
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
     * @return Operator
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
     * @return Operator
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
     * Set secondaryMail
     *
     * @param string $secondaryMail
     * @return Operator
     */
    public function setSecondaryMail($secondaryMail)
    {
        $this->secondaryMail = $secondaryMail;

        return $this;
    }

    /**
     * Get secondaryMail
     *
     * @return string 
     */
    public function getSecondaryMail()
    {
        return $this->secondaryMail;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Operator
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
     * Set accessLevel
     *
     * @param integer $accessLevel
     * @return Operator
     */
    public function setAccessLevel($accessLevel)
    {
        $this->accessLevel = $accessLevel;

        return $this;
    }

    /**
     * Get accessLevel
     *
     * @return integer 
     */
    public function getAccessLevel()
    {
        return $this->accessLevel;
    }

    /**
     * Add news
     *
     * @param \Darkish\CategoryBundle\Entity\News $news
     * @return Operator
     */
    public function addNews(\Darkish\CategoryBundle\Entity\News $news)
    {
        $this->news[] = $news;

        return $this;
    }

    /**
     * Remove news
     *
     * @param \Darkish\CategoryBundle\Entity\News $news
     */
    public function removeNews(\Darkish\CategoryBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNews()
    {
        return $this->news;
    }
}
