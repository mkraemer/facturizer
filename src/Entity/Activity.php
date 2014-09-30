<?php

namespace Facturizer\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Facturizer\Entity\Activity
 *
 * @Serializer\AccessType("public_method")
 */
class Activity
{
    use HandleTrait;

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
     * @Serializer\Type("double")
     */
    private $hoursEstimated;

    /**
     * @Serializer\Type("boolean")
     */
    private $isBillable;

    /**
     * @Serializer\Type("string")
     */
    private $invoiceId;

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
     * set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return array hoursSpent
     */
    public function getHoursSpent()
    {
        return $this->hoursSpent;
    }

    /**
     * set hoursSpent
     *
     * @param array $hoursSpent
     */
    public function setHoursSpent($hoursSpent)
    {
        $this->hoursSpent = $hoursSpent;

        return $this;
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
    public function getIsBillable()
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

    /**
     * get invoiceId
     *
     * @return string invoiceId
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * set invoiceId
     *
     * @param string $invoiceId
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;

        return $this;
    }

    /**
     * get hoursEstimated
     *
     * @return double hoursEstimated
     */
    public function getHoursEstimated()
    {
        return $this->hoursEstimated;
    }

    /**
     * set hoursEstimated
     *
     * @param double $hoursEstimated
     */
    public function setHoursEstimated($hoursEstimated)
    {
        $this->hoursEstimated = $hoursEstimated;

        return $this;
    }
}
