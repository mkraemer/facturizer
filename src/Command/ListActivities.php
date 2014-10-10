<?php

namespace Facturizer\Command;

use Facturizer\TextHelper,
    Facturizer\Storage\ObjectStorage;
use League\CLImate\CLImate;

/**
 * Command\ListActivities
 */
class ListActivities
{
    protected $objectStorage;

    protected $climate;

    public function __construct(ObjectStorage $objectStorage, Climate $climate)
    {
        $this->objectStorage = $objectStorage;

        $this->climate = $climate;
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
            $this->climate->info('You have no active activities');
            return;
        }

        $data = [];
        foreach ($activities as $activity) {
            $data[] = [
                '<underline>Handle</underline>'    => $activity->getHandle(),
                '<underline>Activity</underline>'  => $activity->getName(),
                '<underline>Client</underline>'    => $activity->getProject()->getClient()->getName(),
                '<underline>Project</underline>'   => $activity->getProject()->getName(),
                '<underline>Est. (h)</underline>'  => (string)$activity->getHoursEstimated(),
                '<underline>Spent (h)</underline>' => (string)$activity->getHoursSpent(),
                '<underline>Billable</underline>'  => $activity->isBillable() ? '√' : ''
            ];
        }

        $this->climate->table($data);
    }

    public function getDescription()
    {
        return 'Lists all active activities';
    }
}
