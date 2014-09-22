<?php

namespace Facturizer\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facturizer\Entity\Project
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Project
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
     * @var text
     *
     * @ORM\Column(name="name", type="text")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="projects")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="Activity", mappedBy="project")
     */
    private $activities;

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
     * @return ArrayCollection activities
     */
    public function getActivities()
    {
        return $this->activities;
    }
}
