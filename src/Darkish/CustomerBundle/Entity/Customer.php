<?php

namespace Darkish\CustomerBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\VirtualProperty;
use JMS\Serializer\Annotation\SerializedName;
use Darkish\UserBundle\Validator\Constraints\ValidName;


/**
 * Acme\UserBundle\Entity\User
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="Darkish\CustomerBundle\Entity\CustomerRepository")
 * @UniqueEntity(
 *     fields={"username"},
 *     errorPath="username",
 *     message="نام کاربری تکراری استss."
 * )
 *
 */
class Customer implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"customer.list", "customer.details", "product.list", "product.details", "message.details",
     * "message.list", "api.list", "api.body"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\Email(
     *     message = "The username '{{ value }}' is not a valid email."
     * )
     * @Groups({"customer.list", "customer.details", "comment.details", "message.details", "message.list", "api.list", "api.body"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"none"})
     */
    private $password;
    
    private $newPassword;

    

    /**
     * @ORM\Column(name="is_active", type="boolean")
     * @Groups({"customer.list", "customer.details"})
     */
    private $isActive;
    
    /**
     * @ORM\Column(name="created", type="datetime")
     * @Groups({"customer.list", "customer.details"})
     */
    private $created;

    /**
     *
     * @ORM\ManyToOne(targetEntity="\Darkish\CategoryBundle\Entity\Record", inversedBy="customers")
     * @ORM\JoinColumn(name="record_id", referencedColumnName="id", onDelete="CASCADE")
     * @Groups({"customer.list", "customer.details"})
     */
    private $record;

    /**
     * @var integer
     *
     * @ORM\Column(name="record_access_level", type="integer")
     */
    private $recordAccessLevel;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Darkish\CategoryBundle\Entity\Message", mappedBy="customer", cascade={"remove"})
     */
    private $messages;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Darkish\CategoryBundle\Entity\DBase", mappedBy="customer", cascade={"remove"})
     */
    private $dbaseItems;

    
    /**
     *
     * @var string 
     * @ORM\Column(name="type", type="string")
     * @Assert\Choice(choices = {"owner", "assistant"}, message = "Choose a valid type.")
     * @Groups({"customer.list", "customer.details", "api.list", "api.body"})
     */
    private $type;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="phone_one", type="string", nullable=true)
     * @Groups({"customer.list", "customer.details", "api.list", "api.body"})
     */
    private $phoneOne;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="phone_two", type="string", nullable=true)
     * @Groups({"customer.list", "customer.details", "api.list", "api.body"})
     */
    private $phoneTwo;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="phone_three", type="string", nullable=true)
     * @Groups({"customer.list", "customer.details", "api.list", "api.body"})
     */
    private $phoneThree;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="phone_four", type="string", nullable=true)
     * @Groups({"customer.list", "customer.details", "api.list", "api.body"})
     */
    private $phoneFour;
    
    /**
     *
     * @var string
     * @ORM\Column(name="full_name", type="string", nullable=true) 
     * @Groups({"customer.list", "customer.details", "api.list", "api.body"})
     * @ValidName
     */
    private $fullName;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="\Darkish\CategoryBundle\Entity\ManagedFile")
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id")
     * @Groups({"customer.list", "customer.details", "comment.details", "message.details", "message.list", "api.list", "api.body"})
     * 
     *
     */
    private $photo;


    /**
     * @ORM\ManyToMany(targetEntity="CustomerRole", inversedBy="assistants")
     * @Groups({"customer.list", "customer.details"})
     */
    private $assistantAccess;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Darkish\CategoryBundle\Entity\MessageThread", mappedBy="customer", cascade={"remove"})
     */
    private $messageThreads;

    /**
     * @var \DateTime
     * @ORM\Column(name="expire_date", type="datetime", nullable=true)
     * @Groups({"customer.list", "customer.details", "api.list", "api.details"})
     */
    private $expireDate;

    /**
     *
     * @Groups({"customer.list", "customer.details"})
     */
    private $roles;


    
    /**
     * @ORM\OneToMany(targetEntity="\Darkish\CommentBundle\Entity\CustomerComment", mappedBy="owner")
     * 
     */
    private $comments;

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
        if(!$this->roles) {
            $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        }
        
        return $this->roles->toArray();
        
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
        $now = new \DateTime();
        return ($this->isActive && $this->expireDate > $now && $this->recordAccessLevel > 1);
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
     * @return Customer
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
     * @return Customer
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }
    
    /**
     * Set password
     *
     * @param string $newPassword
     * @return Operator
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
        $this->password = '';
        return $this;
    }
    
    /**
     * Get newPassword
     *
     * @return string 
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Customer
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
     * @return Customer
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
     * @param \Darkish\CustomerBundle\Entity\CustomerRole $roles
     * @return Customer
     */
    public function addRole(\Darkish\CustomerBundle\Entity\CustomerRole $roles)
    {
        if(!$this->roles) {
            $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        }
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Darkish\CustomerBundle\Entity\CustomerRole $roles
     */
    public function removeRole(\Darkish\CustomerBundle\Entity\CustomerRole $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Add assistantAccess
     *
     * @param \Darkish\CustomerBundle\Entity\CustomerRole $assistantAccess
     * @return Customer
     */
    public function addAssistantAccess(\Darkish\CustomerBundle\Entity\CustomerRole $assistantAccess)
    {
        $this->assistantAccess[] = $assistantAccess;

        return $this;
    }

    /**
     * Remove assistantAccess
     *
     * @param \Darkish\CustomerBundle\Entity\CustomerRole $assistantAccess
     */
    public function removeAssistantAccess(\Darkish\CustomerBundle\Entity\CustomerRole $assistantAccess)
    {
        $this->assistantAccess->removeElement($assistantAccess);
    }

    /**
     * Get assistantAccess
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssistantAccess()
    {
        return $this->assistantAccess;
    }

    public function clearAssistantAccess() {
        $this->assistantAccess = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->isActive = true;
        $this->assistantAccess = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Customer
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
     * Set type
     *
     * @param string $type
     * @return Customer
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     * @return Customer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return integer 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set record
     *
     * @param \Darkish\CategoryBundle\Entity\Record $record
     * @return Customer
     */
    public function setRecord(\Darkish\CategoryBundle\Entity\Record $record = null)
    {
        $this->record = $record;

        return $this;
    }

    /**
     * Get record
     *
     * @return \Darkish\CategoryBundle\Entity\Record 
     */
    public function getRecord()
    {
        return $this->record;
    }

    /**
     * Set phoneOne
     *
     * @param integer $phoneOne
     * @return Customer
     */
    public function setPhoneOne($phoneOne)
    {
        $this->phoneOne = $phoneOne;

        return $this;
    }

    /**
     * Get phoneOne
     *
     * @return integer 
     */
    public function getPhoneOne()
    {
        return $this->phoneOne;
    }

    /**
     * Set phoneTwo
     *
     * @param integer $phoneTwo
     * @return Customer
     */
    public function setPhoneTwo($phoneTwo)
    {
        $this->phoneTwo = $phoneTwo;

        return $this;
    }

    /**
     * Get phoneTwo
     *
     * @return integer 
     */
    public function getPhoneTwo()
    {
        return $this->phoneTwo;
    }

    /**
     * Set phoneThree
     *
     * @param integer $phoneThree
     * @return Customer
     */
    public function setPhoneThree($phoneThree)
    {
        $this->phoneThree = $phoneThree;

        return $this;
    }

    /**
     * Get phoneThree
     *
     * @return integer 
     */
    public function getPhoneThree()
    {
        return $this->phoneThree;
    }

    /**
     * Set phoneFour
     *
     * @param integer $phoneFour
     * @return Customer
     */
    public function setPhoneFour($phoneFour)
    {
        $this->phoneFour = $phoneFour;

        return $this;
    }

    /**
     * Get phoneFour
     *
     * @return integer 
     */
    public function getPhoneFour()
    {
        return $this->phoneFour;
    }

    /**
     * Set photo
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $photo
     * @return Customer
     */
    public function setPhoto(\Darkish\CategoryBundle\Entity\ManagedFile $photo = null)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return \Darkish\CategoryBundle\Entity\ManagedFile 
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     * @return Customer
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string 
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @return string
     * @VirtualProperty
     * @SerializedName("display_info")
     * @Groups({"api.list", "api.details"})
     */
    public function gedDisplayInfo()
    {
        $displayInfo = [];
        $displayInfo['name'] = $this->getFullName();
        $displayInfo['photo'] = $this->photo;

        return $displayInfo;
    }


    /**
     * Set expireDate
     *
     * @param \DateTime $expireDate
     *
     * @return Customer
     */
    public function setExpireDate($expireDate)
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    /**
     * Get expireDate
     *
     * @return \DateTime
     */
    public function getExpireDate()
    {
        return $this->expireDate;
    }

    /**
     * Add message
     *
     * @param \Darkish\CategoryBundle\Entity\Message $message
     *
     * @return Customer
     */
    public function addMessage(\Darkish\CategoryBundle\Entity\Message $message)
    {
        $this->messages[] = $message;

        return $this;
    }

    /**
     * Remove message
     *
     * @param \Darkish\CategoryBundle\Entity\Message $message
     */
    public function removeMessage(\Darkish\CategoryBundle\Entity\Message $message)
    {
        $this->messages->removeElement($message);
    }

    /**
     * Get messages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Add dbaseItem
     *
     * @param \Darkish\CategoryBundle\Entity\DBase $dbaseItem
     *
     * @return Customer
     */
    public function addDbaseItem(\Darkish\CategoryBundle\Entity\DBase $dbaseItem)
    {
        $this->dbaseItems[] = $dbaseItem;

        return $this;
    }

    /**
     * Remove dbaseItem
     *
     * @param \Darkish\CategoryBundle\Entity\DBase $dbaseItem
     */
    public function removeDbaseItem(\Darkish\CategoryBundle\Entity\DBase $dbaseItem)
    {
        $this->dbaseItems->removeElement($dbaseItem);
    }

    /**
     * Get dbaseItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDbaseItems()
    {
        return $this->dbaseItems;
    }

    /**
     * Add messageThread
     *
     * @param \Darkish\CategoryBundle\Entity\MessageThread $messageThread
     *
     * @return Customer
     */
    public function addMessageThread(\Darkish\CategoryBundle\Entity\MessageThread $messageThread)
    {
        $this->messageThreads[] = $messageThread;

        return $this;
    }

    /**
     * Remove messageThread
     *
     * @param \Darkish\CategoryBundle\Entity\MessageThread $messageThread
     */
    public function removeMessageThread(\Darkish\CategoryBundle\Entity\MessageThread $messageThread)
    {
        $this->messageThreads->removeElement($messageThread);
    }

    /**
     * Get messageThreads
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMessageThreads()
    {
        return $this->messageThreads;
    }

    /**
     * Add comment
     *
     * @param \Darkish\CommentBundle\Entity\CustomerComment $comment
     *
     * @return Customer
     */
    public function addComment(\Darkish\CommentBundle\Entity\CustomerComment $comment)
    {
        $this->comments[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \Darkish\CommentBundle\Entity\CustomerComment $comment
     */
    public function removeComment(\Darkish\CommentBundle\Entity\CustomerComment $comment)
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set recordAccessLevel
     *
     * @param integer $recordAccessLevel
     *
     * @return Customer
     */
    public function setRecordAccessLevel($recordAccessLevel)
    {
        $this->recordAccessLevel = $recordAccessLevel;

        return $this;
    }

    /**
     * Get recordAccessLevel
     *
     * @return integer
     */
    public function getRecordAccessLevel()
    {
        return $this->recordAccessLevel;
    }
}
