<?php

namespace Darkish\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation\Groups;

/**
 * Darkish\UserBundle\Entity\Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity
 */
class Client implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"thread.list", "thread.details"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Groups({"thread.list", "thread.details"})
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64, nullable = true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", name="fullname", nullable = true)
     * @Groups({"thread.list", "thread.details"})
     */
    private $fullName;  

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     *
     * @ORM\ManyToOne(targetEntity="\Darkish\CategoryBundle\Entity\ManagedFile")
     * @ORM\JoinColumn(name="photo_id", referencedColumnName="id")
     * @Groups({"thread.list", "thread.details"})
     *
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity="Darkish\CategoryBundle\Entity\PrivateMessageThread", mappedBy="client")
     */
    private $privateMessageThreads;

    /**
     * @ORM\ManyToMany(targetEntity="Darkish\CategoryBundle\Entity\GroupMessageThread", mappedBy="clients")
     */
    private $groupMessageThreads;

    /**
     * @ORM\OneToMany(targetEntity="\Darkish\CommentBundle\Entity\ClientComment", mappedBy="owner")
     */
    private $comments;

    /**
     * @ORM\ManyToMany(targetEntity="Darkish\CategoryBundle\Entity\Record", inversedBy="clientsFavorited")
     * @ORM\JoinTable(name="favorites")
     */
    private $favoriteRecords;

    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

    public function getId() {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
        return $this;
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
        return array('ROLE_USER');
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

    /**
     * Set password
     *
     * @param string $password
     * @return Client
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return Client
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
     * Add privateMessageThreads
     *
     * @param \Darkish\CategoryBundle\Entity\PrivateMessageThread $privateMessageThreads
     * @return Client
     */
    public function addPrivateMessageThread(\Darkish\CategoryBundle\Entity\PrivateMessageThread $privateMessageThreads)
    {
        $this->privateMessageThreads[] = $privateMessageThreads;

        return $this;
    }

    /**
     * Remove privateMessageThreads
     *
     * @param \Darkish\CategoryBundle\Entity\PrivateMessageThread $privateMessageThreads
     */
    public function removePrivateMessageThread(\Darkish\CategoryBundle\Entity\PrivateMessageThread $privateMessageThreads)
    {
        $this->privateMessageThreads->removeElement($privateMessageThreads);
    }

    /**
     * Get privateMessageThreads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrivateMessageThreads()
    {
        return $this->privateMessageThreads;
    }

    /**
     * Add groupMessageThreads
     *
     * @param \Darkish\CategoryBundle\Entity\GroupMessageThread $groupMessageThreads
     * @return Client
     */
    public function addGroupMessageThread(\Darkish\CategoryBundle\Entity\GroupMessageThread $groupMessageThreads)
    {
        $this->groupMessageThreads[] = $groupMessageThreads;

        return $this;
    }

    /**
     * Remove groupMessageThreads
     *
     * @param \Darkish\CategoryBundle\Entity\GroupMessageThread $groupMessageThreads
     */
    public function removeGroupMessageThread(\Darkish\CategoryBundle\Entity\GroupMessageThread $groupMessageThreads)
    {
        $this->groupMessageThreads->removeElement($groupMessageThreads);
    }

    /**
     * Get groupMessageThreads
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getGroupMessageThreads()
    {
        return $this->groupMessageThreads;
    }

    /**
     * Add favoriteRecords
     *
     * @param \Darkish\CategoryBundle\Entity\Record $favoriteRecords
     * @return Client
     */
    public function addFavoriteRecord(\Darkish\CategoryBundle\Entity\Record $favoriteRecords)
    {
        $this->favoriteRecords[] = $favoriteRecords;

        return $this;
    }

    /**
     * Remove favoriteRecords
     *
     * @param \Darkish\CategoryBundle\Entity\Record $favoriteRecords
     */
    public function removeFavoriteRecord(\Darkish\CategoryBundle\Entity\Record $favoriteRecords)
    {
        $this->favoriteRecords->removeElement($favoriteRecords);
    }

    /**
     * Get favoriteRecords
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFavoriteRecords()
    {
        return $this->favoriteRecords;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     * @return Client
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
     * Add comments
     *
     * @param \Darkish\CommentBundle\Entity\ClientComment $comments
     * @return Client
     */
    public function addComment(\Darkish\CommentBundle\Entity\ClientComment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Darkish\CommentBundle\Entity\ClientComment $comments
     */
    public function removeComment(\Darkish\CommentBundle\Entity\ClientComment $comments)
    {
        $this->comments->removeElement($comments);
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
     * Set photo
     *
     * @param \Darkish\CategoryBundle\Entity\ManagedFile $photo
     *
     * @return Client
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
}
