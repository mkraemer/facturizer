<?php

namespace Facturizer\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Facturizer\Entity\HandleTrait
 */
trait HandleTrait
{
    /**
     * @Serializer\Type("integer")
     */
    private $handle;

    /**
     * get handle
     *
     * @return integer handle
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * set handle
     *
     * @param integer $handle
     */
    public function setHandle($handle)
    {
        $this->handle = $handle;

        return $this;
    }
}
