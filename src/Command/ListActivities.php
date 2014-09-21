<?php

namespace Facturizer\Command;

use Doctrine\ORM\EntityManager;
use Hoa\Console\Cursor,
    Hoa\Console\Chrome\Text;

/**
 * Command\ListActivities
 */
class ListActivities
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke()
    {
        $activities = $this->entityManager
            ->getRepository('Facturizer\Entity\Activity')
            ->findAll();

        if (empty($activities)) {
            Cursor::colorize('fg(yellow)');
            echo 'You have no active activities' . PHP_EOL;
            return;
        }

        $data = [['Id', 'Client', 'Project', 'Time spent']];
        foreach ($activities as $activity) {
            $data[] = [$activity->getId(), $activity->getProject()->getClient()->getName(), $activity->getProject()->getName(), 0];
        }

        echo Text::columnize($data);
    }

    public function getDescription()
    {
        return 'Lists all active activities';
    }
}
