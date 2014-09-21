<?php

namespace Facturizer\Command;

use RuntimeException;
use Facturizer\Exception\InvalidSyntaxException;
use Doctrine\ORM\EntityManager;
use Facturizer\Entity\Activity;

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
        if (count($inputs) != 2) {
            throw new InvalidSyntaxException('Parameters for this command: project-id activity-name');
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

        $this->entityManager->persist($activity);
        $this->entityManager->flush();
    }
}
