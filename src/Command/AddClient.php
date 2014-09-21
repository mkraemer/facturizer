<?php

namespace Facturizer\Command;

use Doctrine\ORM\EntityManager;
use Hoa\Console\Readline\Readline;
use Hoa\Console\Cursor;
use Facturizer\Entity\Client;

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

    public function __invoke()
    {
        Cursor::colorize('fg(yellow)');
        $client = new Client();

        $client->setName(Readline('Name? > '));
        $client->setHourlyRate(Readline('Hourly rate for client? > '));
        $client->setCurrency(Readline('Currency sign? > '));

        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }
}
