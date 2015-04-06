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
}
