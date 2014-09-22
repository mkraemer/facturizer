<?php

namespace Facturizer\Command;

use Doctrine\ORM\EntityManager;
use Hoa\Console\Cursor,
    Hoa\Console\Chrome\Text;

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

        $data = [['Id', 'Project', 'Client', 'Unbilled Hours']];
        foreach ($projects as $project) {
            $unbilledProjectHours = array_reduce(
                $project->getActivities()->toArray(),
                function ($carry, $activity) {
                    return $carry += $activity->getHoursSpent();
                },
                0
            );
            $data[] = [$project->getId(), $project->getName(), $project->getClient()->getName(), $unbilledProjectHours];
        }

        echo Text::columnize($data);
    }

    public function getDescription()
    {
        return 'Lists all active projects';
    }
}
