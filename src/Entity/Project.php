<?php

namespace Facturizer\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Facturizer\Entity\Project
 *
 * @Serializer\AccessType("public_method")
 */
class Project
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
     * @Serializer\Type("Facturizer\Entity\Client")
     */
    private $client;

    /**
     * @Serializer\Type("array<Facturizer\Entity\Activity>")
     */
    private $activities = [];

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
     * get client
     *
     * @return Client client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * set client
     *
     * @param Client $client
     */
    public function setClient($client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * get activities
     *
     * @return array activities
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * set activities
     *
     * @param array $activities
     */
    public function setActivities($activities)
    {
        $this->activities = $activities;

        return $this;
    }

    public function addActivity(Activity $activity)
    {
        $this->activities[] = $activity;
    }
}
