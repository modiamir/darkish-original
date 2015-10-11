<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * DeletedRecords
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class DeletedRecords
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"api.list"})
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deletedAt", type="datetime")
     * @Groups({"api.list"})
     */
    private $deletedAt;


    /**
     * @var integer
     *
     * @ORM\Column(name="recordId", type="integer")
     * @Groups({"api.list"})
     */
    private $recordId;


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
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return DeletedRecords
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set recordId
     *
     * @param integer $recordId
     *
     * @return DeletedRecords
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;

        return $this;
    }

    /**
     * Get recordId
     *
     * @return integer
     */
    public function getRecordId()
    {
        return $this->recordId;
    }
}
