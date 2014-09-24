<?php

namespace Facturizer\Command;

use RuntimeException;
use Hoa\Console\Cursor;
use Facturizer\Entity\Activity,
    Facturizer\Exception\InvalidSyntaxException,
    Facturizer\Storage\ObjectStorage;

/**
 * Facturizer\Command\AddActivity
 */
class AddActivity
{
    protected $objectStorage;

    public function __construct(ObjectStorage $objectStorage)
    {
        $this->objectStorage = $objectStorage;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) < 2) {
            throw new InvalidSyntaxException('Parameters for this command: project-id activity-name [--unbilled]');
        }

        $projectId = array_shift($inputs);

        $clients = $this->objectStorage->get();
        $project = array_reduce(
            $clients,
            function ($carry, $client) use ($projectId) {
                if ($carry) {
                    return $carry;
                }

                foreach ($client->getProjects() as $project) {
                    if ($project->getId() == $projectId) {
                        return $project;
                    }
                }
            }
        );

        if (!$project) {
            throw new RuntimeException('Project not found');
        }

        $name = array_shift($inputs);

        $activity = new Activity($project);
        $activity->setName($name);

        if (array_key_exists('unbilled', $switches) && $switches['unbilled']) {
            $activity->setIsBillable(false);
        }

        $project->addActivity($activity);

        Cursor::colorize('fg(green)');
        echo 'Activity created with id ' . $activity->getId() . PHP_EOL;
    }

    public function getDescription()
    {
        return 'Creates a new activity for a project';
    }
}
