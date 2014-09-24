<?php

namespace Facturizer\Command;

use Hoa\Console\Cursor;
use Facturizer\TextHelper,
    Facturizer\Storage\ObjectStorage;

/**
 * Command\ListProjects
 */
class ListProjects
{
    protected $clientStorage;

    public function __construct(ObjectStorage $clientStorage)
    {
        $this->clientStorage = $clientStorage;
    }

    public function __invoke()
    {
        $clients = $this->clientStorage->get();
        $projects = [];
        foreach ($clients as $client) {
            foreach ($client->getProjects() as $project) {
                $project->setClient($client);
                $projects[] = $project;
            }
        }

        if (empty($projects)) {
            Cursor::colorize('fg(yellow)');
            echo 'You have no active projects' . PHP_EOL;
            return;
        }

        $data = [['Handle', 'Project', 'Client', 'Unbilled Hours']];
        foreach ($projects as $client => $project) {
            $unbilledProjectHours = array_reduce(
                $project->getActivities(),
                function ($carry, $activity) {
                    if (!$activity->isBillable()) {
                        return $carry;
                    }
                    return $carry += $activity->getHoursSpent();
                },
                0
            );
            $data[] = [$project->getHandle(), $project->getName(), $project->getClient()->getName(), $unbilledProjectHours];
        }

        echo TextHelper::buildTable($data);
    }

    public function getDescription()
    {
        return 'Lists all active projects';
    }
}
