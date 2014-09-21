<?php

namespace Facturizer\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Facturizer\Entity\Client
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class Client
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
     * @ORM\OneToMany(targetEntity="Project", mappedBy="client")
     */
    private $projects;

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
     * get projects
     *
     * @return ArrayCollection projects
     */
    public function getProjects()
    {
        return $this->projects;
    }
}
