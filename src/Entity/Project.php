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
}
