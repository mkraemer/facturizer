<?php

namespace Facturizer\Entity;

use DateInterval;
use Doctrine\ORM\Mapping as ORM;

/**
 * Facturizer\Entity\Activity
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Activity
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
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="activities")
     */
    private $project;

    /**
     * @var object
     *
     * @ORM\Column(name="time_spent", type="object")
     */
    private $timeSpent;

    public function __construct(Project $project)
    {
        $this->project = $project;
        $this->timeSpent = new DateInterval('PT0H');
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
     * get timeSpent
     *
     * @return DateInterval timeSpent
     */
    public function getTimeSpent()
    {
        return $this->timeSpent;
    }

    /**
     * set timeSpent
     *
     * @param DateInterval $timeSpent
     */
    public function setTimeSpent(DateInterval $timeSpent)
    {
        $this->timeSpent = $timeSpent;

        return $this;
    }
}
