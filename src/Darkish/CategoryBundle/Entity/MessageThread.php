<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * MessageThread
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"group" = "GroupMessageThread", "private" = "PrivateMessageThread"})
 */
class MessageThread
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"thread.list", "thread.details", "message.list", "message.details"})
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Record", inversedBy="messageThreads")
     * @ORM\JoinColumn(name="record", referencedColumnName="id")
     * 
     */
    protected $record;

    /**
     * @ORM\OneToMany(targetEntity="Message", mappedBy="thread")
     */
    protected $messages;

    /**
     * @Groups({"thread.list", "thread.details"})
     */
    protected $lastMessage;

    /**
     * @ORM\Column(name="last_record_seen", type="integer")
     * @Groups({"thread.list", "thread.details"})
     */
    protected $lastRecordSeen = 0;

    /**
     * @ORM\Column(name="last_record_delivered", type="integer")
     * @Groups({"thread.list", "thread.details"})
     */
    protected $lastRecordDelivered = 0;

    /**
     * @ORM\Column(name="last_client_seen", type="integer")
     * @Groups({"thread.list", "thread.details"})
     */
    protected $lastClientSeen = 0;

    /**
     * @ORM\Column(name="last_client_delivered", type="integer")
     * @Groups({"thread.list", "thread.details"})
     */
    protected $lastClientDelivered = 0;



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
     * Constructor
     */
    public function __construct()
    {
        $this->messages = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set record
     *
     * @param \Darkish\CategoryBundle\Entity\Record $record
     * @return MessageThread
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
     * @return MessageThread
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

    public function getLastMessage() {
        return $this->lastMessage;
    }

    public function setLastMessage(\Darkish\CategoryBundle\Entity\Message $message) {
        $this->lastMessage = $message;
    }

    /**
     * Set lastRecordSeen
     *
     * @param integer $lastRecordSeen
     * @return MessageThread
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
     * @return MessageThread
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
     * @return MessageThread
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
     * @return MessageThread
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
}
