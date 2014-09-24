<?php

namespace Facturizer\Command;

use Hoa\Console\Cursor;
use Facturizer\TextHelper,
    Facturizer\Storage\ObjectStorage;

/**
 * Command\ListActivities
 */
class ListActivities
{
    protected $objectStorage;

    public function __construct(ObjectStorage $objectStorage)
    {
        $this->objectStorage = $objectStorage;
    }

    public function __invoke()
    {
        $activities = array_reduce(
            $this->objectStorage->get(),
            function ($carry, $client) {
                foreach ($client->getProjects() as $project) {
                    $project->setClient($client);
                    foreach ($project->getActivities() as $activity) {
                        $activity->setProject($project);
                        $carry[] = $activity;
                    }
                }
                return $carry;
            },
            []
        );

        if (empty($activities)) {
            Cursor::colorize('fg(yellow)');
            echo 'You have no active activities' . PHP_EOL;
            return;
        }

        $data = [['Id', 'Activity', 'Client', 'Project', 'Time spent (h)', 'Billable']];
        foreach ($activities as $activity) {
            $data[] = [$activity->getId(), $activity->getName(), $activity->getProject()->getClient()->getName(), $activity->getProject()->getName(), $activity->getHoursSpent(), $activity->isBillable() ? '√' : ''];
        }

        echo TextHelper::buildTable($data);
    }

    public function getDescription()
    {
        return 'Lists all active activities';
    }
}
