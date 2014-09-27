<?php

namespace Facturizer\Command;

use RuntimeException;
use Hoa\Console\Readline\Readline,
    Hoa\Console\Readline\Autocompleter\Word as WordAutocompleter,
    Hoa\Console\Cursor;
use Facturizer\Exception\InvalidSyntaxException,
    Facturizer\Storage\ObjectStorage,
    Facturizer\Service\HandleService,
    Facturizer\Entity\Client,
    Facturizer\Entity\Project;

/**
 * Facturizer\Command\AddProject
 */
class AddProject
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
        if (count($inputs) != 2) {
            throw new InvalidSyntaxException('Parameters for this command: client-id project-name');
        }

        Cursor::colorize('fg(yellow)');
        $project = new Project();
        $this->handleService->assignHandle($project);

        $clientHandle = array_shift($inputs);
        $client = $this->clientStorage->getOne(function ($client) use ($clientHandle) {return ($client->getHandle() == $clientHandle);});

        if (!$client) {
            throw new RuntimeException('Client not found');
        }

        $project->setName(array_shift($inputs));

        $client->addProject($project);

        Cursor::colorize('fg(green)');
        echo 'Project created with id ' . $project->getHandle() . PHP_EOL;
    }

    public function getDescription()
    {
        return 'Creates a new project for a client';
    }
}
