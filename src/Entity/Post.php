<?php

namespace Facturizer\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Facturizer\Entity\Post
 */
class Post
{
    /**
     * @Serializer\Type("string")
     */
    private $id;

    /**
     * @Serializer\Type("string")
     */
    private $activityName;

    /**
     * @Serializer\Type("string")
     */
    private $projectName;

    /**
     * @Serializer\Type("double")
     */
    private $amount;

    /**
     * @Serializer\Type("double")
     */
    private $rate;

    /**
     * @Serializer\Type("double")
     */
    private $total;

    public function __construct($activityName, $projectName, $amount, $rate, $total)
    {
        $this->id = uniqid();

        $this->activityName = $activityName;

        $this->projectName = $projectName;

        $this->amount = $amount;

        $this->rate = $rate;

        $this->total = $total;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getActivityName()
    {
        return $this->activityName;
    }

    public function getProjectName()
    {
        return $this->projectName;
    }
}
