<?php

namespace Facturizer\Entity;

use JMS\Serializer\Annotation as Serializer;

/**
 * Facturizer\Entity\Invoice
 */
class Invoice
{
    /**
     * @Serializer\Type("array<Facturizer\Entity\Project>")
     */
    private $posts = [];

    /**
     * @Serializer\Type("string")
     */
    private $total;

    /**
     * @Serializer\Type("string")
     */
    private $currency;

    /**
     * @Serializer\Type("string")
     */
    private $id;

    /**
     * @Serializer\Type("string")
     */
    private $serial;

    public function __construct($serial, $currency)
    {
        $this->id = uniqid();

        $this->serial = $serial;

        $this->currency = $currency;
    }

    public function addPost(Post $post)
    {
        $this->posts[] = $post;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * get total
     *
     * @return double total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * set total
     *
     * @param double $total
     */
    public function setTotal($total)
    {
        $this->total = $total;

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

    public function getSerial()
    {
        return $this->serial;
    }
}
