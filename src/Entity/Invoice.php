<?php

namespace Facturizer\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Facturizer\Entity\Invoice
 */
class Invoice
{
    protected $activities;

    protected $builtOutput;

    public function __construct()
    {
        $this->activities = new ArrayCollection();
    }

    public function getActivities()
    {
        return $this->activities;
    }
}
