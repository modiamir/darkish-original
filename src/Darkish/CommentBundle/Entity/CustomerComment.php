<?php

namespace Darkish\CommentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Darkish\CommentBundle\Entity\Comment;
use JMS\Serializer\Annotation\Groups;
/**
 * UserComment
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CustomerComment extends Comment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups("comment.details")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="\Darkish\CustomerBundle\Entity\Customer", inversedBy="comments")
     * @ORM\JoinColumn(name="owner_id", referencedColumnName="id")
     * @Groups("comment.details")
     */
    private $owner;

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
     * Set owner
     *
     * @param \Darkish\CustomerBundle\Entity\Customer $owner
     * @return CustomerComment
     */
    public function setOwner(\Darkish\CustomerBundle\Entity\Customer $owner = null)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Darkish\CustomerBundle\Entity\Customer 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    
}
