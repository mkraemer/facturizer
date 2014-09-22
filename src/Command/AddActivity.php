<?php

namespace Facturizer\Command;

use RuntimeException;
use Doctrine\ORM\EntityManager;
use Hoa\Console\Cursor;
use Facturizer\Entity\Activity,
    Facturizer\Exception\InvalidSyntaxException;

/**
 * Facturizer\Command\AddActivity
 */
class AddActivity
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) < 2) {
            throw new InvalidSyntaxException('Parameters for this command: project-id activity-name [--unbilled]');
        }

        $projectId = array_shift($inputs);

        $project = $this->entityManager
            ->getRepository('Facturizer\Entity\Project')
            ->findOneById($projectId);
        if (!$project) {
            throw new RuntimeException('Project not found');
        }

        $name = array_shift($inputs);

        $activity = new Activity($project);
        $activity->setName($name);

        if (array_key_exists('unbilled', $switches) && $switches['unbilled']) {
            $activity->setIsBillable(false);
        }

        $this->entityManager->persist($activity);
        $this->entityManager->flush();

        Cursor::colorize('fg(green)');
        echo 'Activity created with id ' . $activity->getId() . PHP_EOL;
    }

    public function getDescription()
    {
        return 'Creates a new activity for a project';
    }
}
