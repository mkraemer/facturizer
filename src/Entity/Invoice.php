<?php

namespace Facturizer\Entity;

/**
 * Facturizer\Entity\Invoice
 */
class Invoice
{
    protected $activities = [];

    protected $builtOutput;

    public function getActivities()
    {
        return $this->activities;
    }
}
