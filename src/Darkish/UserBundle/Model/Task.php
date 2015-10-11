<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 10/11/15
 * Time: 3:19 PM
 */

namespace Darkish\UserBundle\Model;


use Symfony\Component\Validator\Constraints as Assert;



class Task
{
    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="int")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $taskType;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $taskValue;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private $entityType;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Type(type="int")
     */
    private $entityId;

    public function getId() {

        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getTaskType() {

        return $this->taskType;
    }

    public function setTaskType($taskType)
    {
        $this->taskType = $taskType;

        return $this;
    }

    public function getTaskValue() {

        return $this->taskValue;
    }

    public function setTaskValue($taskValue)
    {
        $this->taskValue = $taskValue;

        return $this;
    }

    public function getEntityType() {

        return $this->entityType;
    }

    public function setEntityType($entityType)
    {
        $this->entityType = $entityType;

        return $this;
    }

    public function getEntityId() {

        return $this->entityId;
    }

    public function setEntityId($entityId)
    {
        $this->entityId = $entityId;

        return $this;
    }

}