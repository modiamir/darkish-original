<?php

namespace Darkish\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApiToken
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ApiToken
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
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=20, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(name="device_id", type="string", length=255, unique=true)
     */
    private $deviceId;

    /**
     * @ORM\OneToOne(targetEntity="Client")
     */
    private $client;

    /**
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(name="expire", type="datetime")
     */
    private $expire;




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
     * Set token
     *
     * @param string $token
     * @return ApiToken
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * Get token
     *
     * @return string 
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return ApiToken
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set deviceId
     *
     * @param string $deviceId
     * @return ApiToken
     */
    public function setDeviceId($deviceId)
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    /**
     * Get deviceId
     *
     * @return string 
     */
    public function getDeviceId()
    {
        return $this->deviceId;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return ApiToken
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
     * Set expire
     *
     * @param \DateTime $expire
     * @return ApiToken
     */
    public function setExpire($expire)
    {
        $this->expire = $expire;

        return $this;
    }

    /**
     * Get expire
     *
     * @return \DateTime 
     */
    public function getExpire()
    {
        return $this->expire;
    }

    /**
     * Set client
     *
     * @param \Darkish\UserBundle\Entity\Client $client
     * @return ApiToken
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
}
