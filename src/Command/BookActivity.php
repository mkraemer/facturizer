<?php

namespace Facturizer\Command;

use RuntimeException;
use Hoa\Console\Cursor;
use Facturizer\Entity\Activity,
    Facturizer\Service\ActivityService,
    Facturizer\Storage\ObjectStorage,
    Facturizer\Exception\InvalidSyntaxException;

/**
 * Facturizer\Command\BookActivity
 */
class BookActivity
{
    protected $objectStorage;

    public function __construct(ObjectStorage $objectStorage)
    {
        $this->objectStorage = $objectStorage;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) < 2) {
            throw new InvalidSyntaxException('Parameters for this command: activity-id time-spec');
        }
        $activityId = array_shift($inputs);

        $activity = array_reduce(
            $this->objectStorage->get(),
            function ($carry, $client) use ($activityId) {
                if ($carry) {
                    return $carry;
                }

                foreach ($client->getProjects() as $project) {
                    foreach ($project->getActivities() as $activity) {
                        if ($activity->getId() == $activityId) {
                            return $activity;
                        }
                    }
                }
            }
        );

        if (!$activity) {
            throw new RuntimeException('Activity not found');
        }

        $timeSpec = array_shift($inputs);

        $hoursSpentBefore = $activity->getHoursSpent();
        $activity->addHoursSpent($timeSpec);

        Cursor::colorize('fg(green)');
        echo sprintf('Time spent for activity "%s" is now at %sh (Before: %sh)', $activity->getName(), $activity->getHoursSpent(), $hoursSpentBefore), PHP_EOL;
    }

    public function getDescription()
    {
        return 'Increases the time spent on an activity';
    }
}
