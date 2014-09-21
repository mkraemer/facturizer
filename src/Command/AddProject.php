<?php

namespace Facturizer\Command;

use Doctrine\ORM\EntityManager;
use Hoa\Console\Readline\Readline;
use Hoa\Console\Cursor;
use Facturizer\Entity\Project;

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
        Cursor::colorize('fg(yellow)');
        $project = new Project();

        $project->setName(Readline('Name?> '));
    }
}
