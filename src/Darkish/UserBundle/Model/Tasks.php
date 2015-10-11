<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/11/15
 * Time: 4:16 PM
 */

namespace Darkish\UserBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;


class Tasks
{
    /**
     * @Assert\Count(min="1")
     */
    private $tasks;

    public function __construct()
    {
        $this->tasks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addTask(\Darkish\UserBundle\Model\Task $task)
    {
        $this->tasks[] = $task;

        return $this;
    }

    public function removeTask(\Darkish\UserBundle\Model\Task $task)
    {
        $this->tasks->removeElement($task);
    }

    /**
     * Get marketGroups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}