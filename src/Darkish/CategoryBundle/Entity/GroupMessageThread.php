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
}
