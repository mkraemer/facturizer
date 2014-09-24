<?php

namespace Facturizer\Command;

use RuntimeException;
use Hoa\Console\Readline\Readline,
    Hoa\Console\Readline\Autocompleter\Word as WordAutocompleter,
    Hoa\Console\Cursor;
use Facturizer\Exception\InvalidSyntaxException,
    Facturizer\Entity\Client,
    Facturizer\Storage\ObjectStorage,
    Facturizer\Entity\Project;

/**
 * Facturizer\Command\AddProject
 */
class AddProject
{
    protected $clientStorage;

    public function __construct(ObjectStorage $clientStorage)
    {
        $this->clientStorage = $clientStorage;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) != 2) {
            throw new InvalidSyntaxException('Parameters for this command: client-id project-name');
        }

        Cursor::colorize('fg(yellow)');
        $project = new Project();

        $clientId = array_shift($inputs);
        $client = $this->clientStorage->getOne(function ($client) use ($clientId) {return ($client->getId() == $clientId);});

        if (!$client) {
            throw new RuntimeException('Client not found');
        }

        $project->setName(array_shift($inputs));

        $client->addProject($project);

        Cursor::colorize('fg(green)');
        echo 'Project created with id ' . $project->getId() . PHP_EOL;
    }

    public function getDescription()
    {
        return 'Creates a new project for a client';
    }
}
