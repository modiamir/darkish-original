<?php

namespace Darkish\CategoryBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * NewsNewsTree
 *
 * @ORM\Table(name="news_trees")
 * @ORM\Entity
 */
class NewsNewsTree
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
     * @ORM\ManyToOne(targetEntity="News",  inversedBy="newstrees")
     * @ORM\JoinColumn(name="news_id", referencedColumnName="id")
     * @Groups({ "newstree.list", "newstree.details"})
     **/
    private $news;
    
    /**
     * @ORM\ManyToOne(targetEntity="NewsTree",  inversedBy="mainnews")
     * @ORM\JoinColumn(name="tree_id", referencedColumnName="id")
     * @Groups({"newstree.list", "newstree.details", "news.list", "news.details", "api.list"})
     **/
    private $tree;
    
    /**
     *
     * @var integer
     * @ORM\Column(name="sort", type="string", nullable=true) 
     * @Groups({"newstree.list", "newstree.details", "news.list", "news.details", "api.list"})
     */
    private $sort;

    /**
     * Set news
     *
     * @param \Darkish\CategoryBundle\Entity\News $news
     * @return NewsNewsTree
     */
    public function setNews(\Darkish\CategoryBundle\Entity\News $news = null)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \Darkish\CategoryBundle\Entity\News 
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set tree
     *
     * @param \Darkish\CategoryBundle\Entity\NewsTree $tree
     * @return NewsNewsTree
     */
    public function setTree(\Darkish\CategoryBundle\Entity\NewsTree $tree = null)
    {
        $this->tree = $tree;

        return $this;
    }

    /**
     * Get tree
     *
     * @return \Darkish\CategoryBundle\Entity\NewsTree 
     */
    public function getTree()
    {
        return $this->tree;
    }

    /**
     * Set sort
     *
     * @param string $sort
     * @return NewsNewsTree
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
