<?php

namespace Darkish\CategoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * Template
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Template
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"template.list", "template.details", "record.store"})
     */
    private $id;

    /**
     * @ORM\Column(name="title", type="string", unique=true)
     * @Groups({"template.list", "template.details", "record.store"})
     */
    private $title;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
