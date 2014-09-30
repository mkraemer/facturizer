<?php

namespace Facturizer\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Facturizer\Entity\Client
 *
 * @Serializer\AccessType("public_method")
 */
class Client
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
     * @Serializer\Type("array<Facturizer\Entity\Project>")
     */
    private $projects = [];

    /**
     * @Serializer\Type("string")
     */
    private $templateName;

    /**
     * @Serializer\Type("integer")
     */
    private $hourlyRate;

    /**
     * @Serializer\Type("string")
     */
    private $currency;

    /**
     * @Serializer\Type("array<Facturizer\Entity\Invoice>")
     */
    private $invoices;

    public function __construct()
    {
        $this->id = uniqid();
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
     * get projects
     *
     * @return array projects
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * set projects
     *
     * @param array $projects
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;

        return $this;
    }

    public function addProject(Project $project)
    {
        $this->projects[] = $project;
    }

    /**
     * get templateName
     *
     * @return string templateName
     */
    public function getTemplateName()
    {
        return $this->templateName;
    }

    /**
     * set templateName
     *
     * @param string $templateName
     */
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;

        return $this;
    }

    /**
     * get hourlyRate
     *
     * @return float hourlyRate
     */
    public function getHourlyRate()
    {
        return $this->hourlyRate;
    }

    /**
     * set hourlyRate
     *
     * @param float $hourlyRate
     */
    public function setHourlyRate($hourlyRate)
    {
        $this->hourlyRate = $hourlyRate;

        return $this;
    }

    /**
     * get currency
     *
     * @return string currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * set currency
     *
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * get invoices
     *
     * @return array invoices
     */
    public function getInvoices()
    {
        return $this->invoices;
    }

    /**
     * set invoices
     *
     * @param array $invoices
     */
    public function setInvoices($invoices)
    {
        $this->invoices = $invoices;

        return $this;
    }
}
