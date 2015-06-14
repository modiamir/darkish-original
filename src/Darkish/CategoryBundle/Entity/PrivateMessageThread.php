<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Darkish\CategoryBundle\Entity\MessageThread;
use JMS\Serializer\Annotation\Groups;

/**
 * PrivateMessageThread
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PrivateMessageThread extends MessageThread
{


    /**
     * @ORM\ManyToOne(targetEntity="Darkish\UserBundle\Entity\Client", inversedBy="privateMessageThreads")
     * @ORM\JoinColumn(name="client", referencedColumnName="id")
     * @Groups({"thread.list", "thread.details"})
     */
    private $client;

    /**
     * @Groups({"thread.list", "thread.details"})
     */
    protected $threadType = 'private';
    
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
     * @var \Darkish\CustomerBundle\Entity\Customer
     * @Groups({"thread.list", "thread.details"})
     */
    protected $customer;

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
     * Set client
     *
     * @param \Darkish\UserBundle\Entity\Client $client
     * @return PrivateMessageThread
     */
    public function setClient(\Darkish\UserBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \Darkish\UserBundle\Entity\Client 
     */
    public function getClient()
    {
        return $this->client;
    }

    public function getThreadType() {
        return $this->threadType;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set lastRecordSeen
     *
     * @param integer $lastRecordSeen
     * @return PrivateMessageThread
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
     * @return PrivateMessageThread
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
     * @return PrivateMessageThread
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
     * @return PrivateMessageThread
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
     * Set customer
     *
     * @param \Darkish\CustomerBundle\Entity\Customer $customer
     * @return PrivateMessageThread
     */
    public function setCustomer(\Darkish\CustomerBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * Get customer
     *
     * @return \Darkish\CustomerBundle\Entity\Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * Add messages
     *
     * @param \Darkish\CategoryBundle\Entity\Message $messages
     * @return PrivateMessageThread
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
     * @return PrivateMessageThread
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
     * @return PrivateMessageThread
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
