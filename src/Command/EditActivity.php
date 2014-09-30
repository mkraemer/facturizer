<?php

namespace Facturizer\Command;

use RuntimeException;
use Hoa\Console\Cursor;
use Facturizer\Entity\Activity,
    Facturizer\Service\ActivityService,
    Facturizer\Service\ObjectEditingService as ObjectEditor,
    Facturizer\Storage\ObjectStorage,
    Facturizer\Exception\InvalidSyntaxException;

/**
 * Facturizer\Command\EditActivity
 */
class EditActivity
{
    protected $objectStorage;

    protected $objectEditor;

    public function __construct(ObjectStorage $objectStorage, ObjectEditor $objectEditor)
    {
        $this->objectStorage = $objectStorage;

        $this->objectEditor = $objectEditor;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) < 1) {
            throw new InvalidSyntaxException('Parameters for this command: activity-id');
        }
        $activityHandle = array_shift($inputs);

        $activity = array_reduce(
            $this->objectStorage->get(),
            function ($carry, $client) use ($activityHandle) {
                if ($carry) {
                    return $carry;
                }

                foreach ($client->getProjects() as $project) {
                    foreach ($project->getActivities() as $activity) {
                        if ($activity->getHandle() == $activityHandle) {
                            return $activity;
                        }
                    }
                }
            }
        );

        if (!$activity) {
            throw new RuntimeException('Activity not found');
        }

        $client = $this->objectStorage->getOne(function ($client) use ($activityHandle) {return ($client->getHandle() == $activityHandle);});
        $this->objectEditor->edit($client);

        Cursor::colorize('fg(green)');
        echo 'Changes detected' . PHP_EOL;
    }

    public function getDescription()
    {
        return 'Increases the time spent on an activity';
    }
}

