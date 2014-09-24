<?php

namespace Facturizer\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Facturizer\Entity\Activity
 */
class Activity
{
    /**
     * @Serializer\Type("string")
     */
    private $id;

    /**
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @Serializer\Type("Facturizer\Entity\Project")
     */
    private $project;

    /**
     * @Serializer\Type("double")
     */
    private $hoursSpent;

    /**
     * @Serializer\Type("boolean")
     */
    private $isBillable;

    /**
     * @Serializer\Type("boolean")
     */
    private $isBilled;

    public function __construct(Project $project)
    {
        $this->id         = uniqid();
        $this->project    = $project;
        $this->hoursSpent = 0;
        $this->isBillable = true;
        $this->isBilled   = false;
    }

    /**
     * get id
     *
     * @return integer id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get name
     *
     * @return string name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * get project
     *
     * @return Project project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * set project
     *
     * @param Project $project
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * get hoursSpent
     *
     * @return float hoursSpent
     */
    public function getHoursSpent()
    {
        return $this->hoursSpent;
    }

    public function addHoursSpent($hours)
    {
        $this->hoursSpent += $hours;
    }

    /**
     * isBillable
     *
     * @return boolean isBillable
     */
    public function isBillable()
    {
        return $this->isBillable;
    }

    /**
     * set isBillable
     *
     * @param boolean $isBillable
     */
    public function setIsBillable($isBillable)
    {
        $this->isBillable = $isBillable;

        return $this;
    }
}
