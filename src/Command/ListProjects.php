<?php

namespace Facturizer\Command;

use Doctrine\ORM\EntityManager;
use Hoa\Console\Cursor;

/**
 * Command\ListProjects
 */
class ListProjects
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke()
    {
        $projects = $this->entityManager
            ->getRepository('Facturizer\Entity\Project')
            ->findAll();

        if (empty($projects)) {
            Cursor::colorize('fg(yellow)');
            echo 'You have no active projects' . PHP_EOL;
            return;
        }
    }

    public function getKey()
    {
        return 'list-projects';
    }
}
