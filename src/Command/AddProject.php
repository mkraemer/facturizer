<?php

namespace Facturizer\Command;

use RuntimeException;
use Doctrine\ORM\EntityManager;
use Hoa\Console\Readline\Readline,
    Hoa\Console\Readline\Autocompleter\Word as WordAutocompleter,
    Hoa\Console\Cursor;
use Facturizer\Exception\InvalidSyntaxException,
    Facturizer\Entity\Client,
    Facturizer\Entity\Project;

/**
 * Facturizer\Command\AddProject
 */
class AddProject
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) != 2) {
            throw new InvalidSyntaxException('Parameters for this command: client-id project-name');
        }

        Cursor::colorize('fg(yellow)');
        $project = new Project();

        $clientId = array_shift($inputs);
        $clientEntityRepository = $this->entityManager
            ->getRepository('Facturizer\Entity\Client');
        $client = $clientEntityRepository->findOneById($clientId);

        if (!$client) {
            throw new RuntimeException('Client not found');
        }

        $project->setClient($client);

        $project->setName(array_shift($inputs));

        $this->entityManager->persist($project);
        $this->entityManager->flush($project);

        Cursor::colorize('fg(green)');
        echo 'Project created with id ' . $project->getId() . PHP_EOL;
    }
}
