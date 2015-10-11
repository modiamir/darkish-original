<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * GroupFilter
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GroupFilter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"maintree.list", "maintree.details", "record.list", "record.details", "api.list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="treeIndex", type="string", length=255)
     * @Groups({"maintree.list", "maintree.details", "record.list", "record.details", "api.list"})
     */
    private $treeIndex;

    /**
     * @var string
     *
     * @ORM\Column(name="filterName", type="string", length=255)
     * @Groups({"maintree.list", "maintree.details", "record.list", "record.details", "api.list"})
     */
    private $filterName;


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
     * Set id
     *
     * @param integer $id
     *
     * @return GroupFilter
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set treeIndex
     *
     * @param string $treeIndex
     *
     * @return GroupFilter
     */
    public function setTreeIndex($treeIndex)
    {
        $this->treeIndex = $treeIndex;

        return $this;
    }

    /**
     * Get treeIndex
     *
     * @return string
     */
    public function getTreeIndex()
    {
        return $this->treeIndex;
    }

    /**
     * Set filterName
     *
     * @param string $filterName
     *
     * @return GroupFilter
     */
    public function setFilterName($filterName)
    {
        $this->filterName = $filterName;

        return $this;
    }

    /**
     * Get filterName
     *
     * @return string
     */
    public function getFilterName()
    {
        return $this->filterName;
    }
}
