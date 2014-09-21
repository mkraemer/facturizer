<?php

namespace Facturizer\Command;

use Doctrine\ORM\EntityManager;
use Hoa\Console\Cursor,
    Hoa\Console\Chrome\Text;

/**
 * Command\ListClients
 */
class ListClients
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke()
    {
        $clients = $this->entityManager
            ->getRepository('Facturizer\Entity\Client')
            ->findAll();

        if (empty($clients)) {
            Cursor::colorize('fg(yellow)');
            echo 'You have no active clients' . PHP_EOL;
            return;
        }

        $data = [['Id', 'Client']];
        foreach ($clients as $client) {
            $data[] = [$client->getId(), $client->getName()];
        }

        echo Text::columnize($data);
    }

    public function getKey()
    {
        return 'list-clients';
    }
}
