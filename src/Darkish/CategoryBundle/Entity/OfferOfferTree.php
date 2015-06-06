<?php

namespace Darkish\CategoryBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * OfferOfferTree
 *
 * @ORM\Table(name="offer_trees")
 * @ORM\Entity
 */
class OfferOfferTree
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
     * @ORM\ManyToOne(targetEntity="Offer",  inversedBy="offertrees")
     * @ORM\JoinColumn(name="offer_id", referencedColumnName="id")
     * @Groups({ "offertree.list", "offertree.details"})
     **/
    private $offer;
    
    /**
     * @ORM\ManyToOne(targetEntity="OfferTree",  inversedBy="mainoffers")
     * @ORM\JoinColumn(name="tree_id", referencedColumnName="id")
     * @Groups({"offertree.list", "offertree.details", "offer.list", "offer.details", "api.list"})
     **/
    private $tree;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="sort", type="integer", nullable=true) 
     * @Groups({"offertree.list", "offertree.details", "offer.list", "offer.details", "api.list"})
     */
    private $sort;

    /**
     * Set offer
     *
     * @param \Darkish\CategoryBundle\Entity\Offer $offer
     * @return OfferOfferTree
     */
    public function setOffer(\Darkish\CategoryBundle\Entity\Offer $offer = null)
    {
        $this->offer = $offer;

        return $this;
    }

    /**
     * Get offer
     *
     * @return \Darkish\CategoryBundle\Entity\Offer 
     */
    public function getOffer()
    {
        return $this->offer;
    }

    /**
     * Set tree
     *
     * @param \Darkish\CategoryBundle\Entity\OfferTree $tree
     * @return OfferOfferTree
     */
    public function setTree(\Darkish\CategoryBundle\Entity\OfferTree $tree = null)
    {
        $this->tree = $tree;

        return $this;
    }

    /**
     * Get tree
     *
     * @return \Darkish\CategoryBundle\Entity\OfferTree 
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * Set sort
     *
     * @param string $sort
     * @return OfferOfferTree
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
