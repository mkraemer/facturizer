<?php

namespace Facturizer\Command;

use Doctrine\ORM\EntityManager;
use Hoa\Console\Cursor;
use Facturizer\Entity\Client,
    Facturizer\Exception\InvalidSyntaxException;

/**
 * Facturizer\Command\AddClient
 */
class AddClient
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) != 4) {
            throw new InvalidSyntaxException('Parameters for this command: client-name hourly-rate currency-sign template-name');
        }

        $client = new Client();

        $client->setName(array_shift($inputs));
        $client->setHourlyRate(array_shift($inputs));
        $client->setCurrency(array_shift($inputs));
        $client->setTemplateName(array_shift($inputs));

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        Cursor::colorize('fg(green)');
        echo 'Client created with id ' . $client->getId() . PHP_EOL;
    }

    public function getDescription()
    {
        return 'Creates a new client';
    }
}
