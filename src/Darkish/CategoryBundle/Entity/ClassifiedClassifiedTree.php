<?php

namespace Darkish\CategoryBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * ClassifiedClassifiedTree
 *
 * @ORM\Table(name="classified_trees")
 * @ORM\Entity
 */
class ClassifiedClassifiedTree
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
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @ORM\ManyToOne(targetEntity="Classified",  inversedBy="classifiedtrees")
     * @ORM\JoinColumn(name="classified_id", referencedColumnName="id")
     * @Groups({ "classifiedtree.list", "classifiedtree.details"})
     **/
    private $classified;
    
    /**
     * @ORM\ManyToOne(targetEntity="ClassifiedTree",  inversedBy="mainclassifieds")
     * @ORM\JoinColumn(name="tree_id", referencedColumnName="id")
     * @Groups({"classifiedtree.list", "classifiedtree.details", "classified.list", "classified.details", "api.list"})
     **/
    private $tree;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="sort", type="integer", nullable=true) 
     * @Groups({"classifiedtree.list", "classifiedtree.details", "classified.list", "classified.details", "api.list"})
     */
    private $sort;

    /**
     * Set classified
     *
     * @param \Darkish\CategoryBundle\Entity\Classified $classified
     * @return ClassifiedClassifiedTree
     */
    public function setClassified(\Darkish\CategoryBundle\Entity\Classified $classified = null)
    {
        $this->classified = $classified;

        return $this;
    }

    /**
     * Get classified
     *
     * @return \Darkish\CategoryBundle\Entity\Classified 
     */
    public function getClassified()
    {
        return $this->classified;
    }

    /**
     * Set tree
     *
     * @param \Darkish\CategoryBundle\Entity\ClassifiedTree $tree
     * @return ClassifiedClassifiedTree
     */
    public function setTree(\Darkish\CategoryBundle\Entity\ClassifiedTree $tree = null)
    {
        $this->tree = $tree;

        return $this;
    }

    /**
     * Get tree
     *
     * @return \Darkish\CategoryBundle\Entity\ClassifiedTree 
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * Set sort
     *
     * @param string $sort
     * @return ClassifiedClassifiedTree
     */
    public function setSort($sort)
    {
        $this->sort = $sort;

        return $this;
    }

    /**
     * Get sort
     *
     * @return string 
     */
    public function getSort()
    {
        return $this->sort;
    }
}
