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
     * @var string
     *
     * @ORM\Column(name="template_name", type="string")
     */
    private $templateName;

    /**
     * @var decimal
     *
     * @ORM\Column(name="hourly_rate", type="decimal", precision=6, scale=2)
     */
    private $hourlyRate;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string")
     */
    private $currency;


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
}
