<?php

namespace Facturizer\Command;

use RuntimeException;
use Hoa\Console\Cursor;
use Facturizer\Entity\Activity,
    Facturizer\Exception\InvalidSyntaxException,
    Facturizer\Service\HandleService,
    Facturizer\Storage\ObjectStorage;

/**
 * Facturizer\Command\AddActivity
 */
class AddActivity
{
    protected $clientStorage;

    protected $handleService;

    public function __construct(ObjectStorage $clientStorage, HandleService $handleService)
    {
        $this->clientStorage = $clientStorage;

        $this->handleService = $handleService;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) < 2) {
            throw new InvalidSyntaxException('Parameters for this command: project-id activity-name [--unbilled]');
        }

        $projectHandle = array_shift($inputs);

        $clients = $this->clientStorage->get();
        $project = array_reduce(
            $clients,
            function ($carry, $client) use ($projectHandle) {
                if ($carry) {
                    return $carry;
                }

                foreach ($client->getProjects() as $project) {
                    if ($project->getHandle() == $projectHandle) {
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
        $this->handleService->assignHandle($activity);
        $activity->setName($name);

        if (array_key_exists('unbilled', $switches) && $switches['unbilled']) {
            $activity->setIsBillable(false);
        }

        $project->addActivity($activity);

        Cursor::colorize('fg(green)');
        echo 'Activity created with handle ' . $activity->getHandle() . PHP_EOL;
    }

    public function getDescription()
    {
        return 'Creates a new activity for a project';
    }
}
