<?php

namespace Darkish\CategoryBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * SponsorSponsorTree
 *
 * @ORM\Table(name="sponsor_trees")
 * @ORM\Entity
 */
class SponsorSponsorTree
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
     * @ORM\ManyToOne(targetEntity="Sponsor",  inversedBy="sponsortrees")
     * @ORM\JoinColumn(name="sponsor_id", referencedColumnName="id")
     * @Groups({ "sponsortree.list", "sponsortree.details"})
     **/
    private $sponsor;
    
    /**
     * @ORM\ManyToOne(targetEntity="SponsorTree",  inversedBy="mainsponsors")
     * @ORM\JoinColumn(name="tree_id", referencedColumnName="id")
     * @Groups({"sponsortree.list", "sponsortree.details", "sponsor.list", "sponsor.details", "api.list"})
     **/
    private $tree;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="sort", type="integer", nullable=true) 
     * @Groups({"sponsortree.list", "sponsortree.details", "sponsor.list", "sponsor.details", "api.list"})
     */
    private $sort;

    /**
     * Set sponsor
     *
     * @param \Darkish\CategoryBundle\Entity\Sponsor $sponsor
     * @return SponsorSponsorTree
     */
    public function setSponsor(\Darkish\CategoryBundle\Entity\Sponsor $sponsor = null)
    {
        $this->sponsor = $sponsor;

        return $this;
    }

    /**
     * Get sponsor
     *
     * @return \Darkish\CategoryBundle\Entity\Sponsor 
     */
    public function getSponsor()
    {
        return $this->sponsor;
    }

    /**
     * Set tree
     *
     * @param \Darkish\CategoryBundle\Entity\SponsorTree $tree
     * @return SponsorSponsorTree
     */
    public function setTree(\Darkish\CategoryBundle\Entity\SponsorTree $tree = null)
    {
        $this->tree = $tree;

        return $this;
    }

    /**
     * Get tree
     *
     * @return \Darkish\CategoryBundle\Entity\SponsorTree 
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * Set sort
     *
     * @param string $sort
     * @return SponsorSponsorTree
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
