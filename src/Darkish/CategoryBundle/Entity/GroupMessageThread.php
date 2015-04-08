<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Darkish\CategoryBundle\Entity\MessageThread;
use JMS\Serializer\Annotation\Groups;

/**
 * GroupMessageThread
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GroupMessageThread extends MessageThread
{

    /**
     * @ORM\ManyToMany(targetEntity="Darkish\UserBundle\Entity\Client", inversedBy="groupMessageThreads")
     * @Groups({"thread.list", "thread.details"})
     */
    private $clients;

    /**
     * @Groups({"thread.list", "thread.details"})
     */
    protected $threadType = 'group';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add clients
     *
     * @param \Darkish\UserBundle\Entity\Client $clients
     * @return GroupMessageThread
     */
    public function addClient(\Darkish\UserBundle\Entity\Client $clients)
    {
        $this->clients[] = $clients;

        return $this;
    }

    /**
     * Remove clients
     *
     * @param \Darkish\UserBundle\Entity\Client $clients
     */
    public function removeClient(\Darkish\UserBundle\Entity\Client $clients)
    {
        $this->clients->removeElement($clients);
    }

    /**
     * Get clients
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClients()
    {
        return $this->clients;
    }

    public function getThreadType() {
        return $this->threadType;
    }
    
    /**
     * @var integer
     * @Groups({"thread.list", "thread.details", "message.list", "message.details"})
     */
    protected $id;

    /**
     * @var integer
     * @Groups({"thread.list", "thread.details"})
     */
    protected $lastRecordSeen;

    /**
     * @var integer
     * @Groups({"thread.list", "thread.details"})
     */
    protected $lastRecordDelivered;

    /**
     * @var integer
     * @Groups({"thread.list", "thread.details"})
     */
    protected $lastClientSeen;

    /**
     * @var integer
     * @Groups({"thread.list", "thread.details"})
     */
    protected $lastClientDelivered;

    /**
     * @var \Darkish\CategoryBundle\Entity\Record
     */
    protected $record;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $messages;


    /**
     * @var boolean
     */
    protected $deletedByRecord;

    /**
     * @var boolean
     */
    protected $deletedByClient;

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
     * Set lastRecordSeen
     *
     * @param integer $lastRecordSeen
     * @return GroupMessageThread
     */
    public function setLastRecordSeen($lastRecordSeen)
    {
        $this->lastRecordSeen = $lastRecordSeen;

        return $this;
    }

    /**
     * Get lastRecordSeen
     *
     * @return integer 
     */
    public function getLastRecordSeen()
    {
        return $this->lastRecordSeen;
    }

    /**
     * Set lastRecordDelivered
     *
     * @param integer $lastRecordDelivered
     * @return GroupMessageThread
     */
    public function setLastRecordDelivered($lastRecordDelivered)
    {
        $this->lastRecordDelivered = $lastRecordDelivered;

        return $this;
    }

    /**
     * Get lastRecordDelivered
     *
     * @return integer 
     */
    public function getLastRecordDelivered()
    {
        return $this->lastRecordDelivered;
    }

    /**
     * Set lastClientSeen
     *
     * @param integer $lastClientSeen
     * @return GroupMessageThread
     */
    public function setLastClientSeen($lastClientSeen)
    {
        $this->lastClientSeen = $lastClientSeen;

        return $this;
    }

    /**
     * Get lastClientSeen
     *
     * @return integer 
     */
    public function getLastClientSeen()
    {
        return $this->lastClientSeen;
    }

    /**
     * Set lastClientDelivered
     *
     * @param integer $lastClientDelivered
     * @return GroupMessageThread
     */
    public function setLastClientDelivered($lastClientDelivered)
    {
        $this->lastClientDelivered = $lastClientDelivered;

        return $this;
    }

    /**
     * Get lastClientDelivered
     *
     * @return integer 
     */
    public function getLastClientDelivered()
    {
        return $this->lastClientDelivered;
    }

    /**
     * Set record
     *
     * @param \Darkish\CategoryBundle\Entity\Record $record
     * @return GroupMessageThread
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
     * Add messages
     *
     * @param \Darkish\CategoryBundle\Entity\Message $messages
     * @return GroupMessageThread
     */
    public function addMessage(\Darkish\CategoryBundle\Entity\Message $messages)
    {
        $this->messages[] = $messages;

        return $this;
    }

    /**
     * Remove messages
     *
     * @param \Darkish\CategoryBundle\Entity\Message $messages
     */
    public function removeMessage(\Darkish\CategoryBundle\Entity\Message $messages)
    {
        $this->messages->removeElement($messages);
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
     * Set deletedByRecord
     *
     * @param boolean $deletedByRecord
     * @return GroupMessageThread
     */
    public function setDeletedByRecord($deletedByRecord)
    {
        $this->deletedByRecord = $deletedByRecord;

        return $this;
    }

    /**
     * Get deletedByRecord
     *
     * @return boolean 
     */
    public function getDeletedByRecord()
    {
        return $this->deletedByRecord;
    }

    /**
     * Set deletedByClient
     *
     * @param boolean $deletedByClient
     * @return GroupMessageThread
     */
    public function setDeletedByClient($deletedByClient)
    {
        $this->deletedByClient = $deletedByClient;

        return $this;
    }

    /**
     * Get deletedByClient
     *
     * @return boolean 
     */
    public function getDeletedByClient()
    {
        return $this->deletedByClient;
    }
}
