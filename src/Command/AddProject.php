<?php

namespace Facturizer\Command;

use Doctrine\ORM\EntityManager;
use Hoa\Console\Readline\Readline,
    Hoa\Console\Readline\Autocompleter\Word as WordAutocompleter,
    Hoa\Console\Cursor;
use Facturizer\Entity\Client,
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

    public function __invoke()
    {
        Cursor::colorize('fg(yellow)');
        $project = new Project();

        /*
         * Autocomplete client:
         */
        $clientEntityRepository = $this->entityManager
            ->getRepository('Facturizer\Entity\Client');

        $clients = $clientEntityRepository->findAll();

        $clientNames = array_map(
            function (Client $client) {
                return $client->getName();
            },
            $clients
        );

        $completingReadline = new Readline();
        $completingReadline->setAutocompleter(new WordAutocompleter($clientNames));

        $clientName = $completingReadline->readline('Client? > ');
        $client = $clientEntityRepository->findOneByName($clientName);

        $project->setClient($client);

        $project->setName(Readline('Project name? > '));

        $this->entityManager->persist($project);
        $this->entityManager->flush($project);
    }
}
