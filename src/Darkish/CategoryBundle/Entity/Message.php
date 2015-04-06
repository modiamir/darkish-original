<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Message
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Message
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"thread.list", "thread.details", "message.list", "message.details"})
     */
    private $id;


    /**
     * @ORM\Column(name="text", type="string")
     * @Groups({"thread.list", "thread.details", "message.list", "message.details"})
     */
    private $text;


    /**
     * @ORM\Column(name="sender", type="string")
     * @Groups({"thread.list", "thread.details", "message.list", "message.details"})
     */
    private $from;

    /**
     * @ORM\Column(name="created", type="datetime")
     * @Groups({"thread.list", "thread.details", "message.list", "message.details"})
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="MessageThread", inversedBy="messages")
     * @ORM\JoinColumn(name="thread", referencedColumnName="id", onDelete="CASCADE")
     * @Groups({"message.list", "message.details"})
     */
    private $thread;


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
     * Set text
     *
     * @param string $text
     * @return Message
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return Message
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
     * Set thread
     *
     * @param \Darkish\CategoryBundle\Entity\MessageThread $thread
     * @return Message
     */
    public function setThread(\Darkish\CategoryBundle\Entity\MessageThread $thread = null)
    {
        $this->thread = $thread;

        return $this;
    }

    /**
     * Get thread
     *
     * @return \Darkish\CategoryBundle\Entity\MessageThread 
     */
    public function getThread()
    {
        return $this->thread;
    }

    /**
     * Set from
     *
     * @param string $from
     * @return Message
     */
    public function setFrom($from)
    {
        $this->from = $from;

        return $this;
    }

    /**
     * Get from
     *
     * @return string 
     */
    public function getFrom()
    {
        return $this->from;
    }
}
