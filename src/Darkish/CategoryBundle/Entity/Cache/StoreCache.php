<?php

namespace Darkish\CategoryBundle\Entity\Cache;

use Darkish\CategoryBundle\Entity\Record as Record;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProductCache
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class StoreCache
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
     * @var Record
     * @ORM\OneToOne(targetEntity="\Darkish\CategoryBundle\Entity\Record")
     */
    private $recordId;

    /**
     * @var array
     *
     * @ORM\Column(name="json", type="json_array")
     */
    private $json;


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
     * Set json
     *
     * @param array $json
     *
     * @return ProductCache
     */
    public function setJson($json)
    {
        $this->json = $json;

        return $this;
    }

    /**
     * Get json
     *
     * @return array
     */
    public function getJson()
    {
        return $this->json;
    }

   

    /**
     * Set recordId
     *
     * @param \Darkish\CategoryBundle\Entity\Cache\Record $recordId
     *
     * @return StoreCache
     */
    public function setRecordId(\Darkish\CategoryBundle\Entity\Record $recordId = null)
    {
        $this->recordId = $recordId;

        return $this;
    }

    /**
     * Get recordId
     *
     * @return \Darkish\CategoryBundle\Entity\Record
     */
    public function getRecordId()
    {
        return $this->recordId;
    }
}
