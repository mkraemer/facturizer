<?php

namespace Facturizer\Command;

use Doctrine\ORM\EntityManager;
use Hoa\Console\Cursor;

/**
 * Facturizer\Command\AddProject
 */
class AddProject
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke()
    {
        
    }
}
