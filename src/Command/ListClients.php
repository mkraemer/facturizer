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

        $data = [['Id', 'Client', 'Projects', 'Unbilled Hours']];
        foreach ($clients as $client) {
            $unbilledHours = array_reduce(
                $client->getProjects()->toArray(),
                function ($carry, $project) {
                    $unbilledProjectHours = array_reduce(
                        $project->getActivities()->toArray(),
                        function ($carry, $activity) {
                            return $carry += $activity->getHoursSpent();
                        },
                        0
                    );
                    return $carry += $unbilledProjectHours;
                },
                0
            );
            $data[] = [$client->getId(), $client->getName(), $client->getProjects()->count(), $unbilledHours];
        }

        echo Text::columnize($data);
    }

    public function getDescription()
    {
        return 'Lists all active clients';
    }
}
