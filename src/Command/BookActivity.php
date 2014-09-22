<?php

namespace Facturizer\Command;

use RuntimeException;
use Doctrine\ORM\EntityManager;
use Hoa\Console\Cursor;
use Facturizer\Entity\Activity,
    Facturizer\Service\ActivityService,
    Facturizer\Exception\InvalidSyntaxException;

/**
 * Facturizer\Command\BookActivity
 */
class BookActivity
{
    protected $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) < 2) {
            throw new InvalidSyntaxException('Parameters for this command: activity-id time-spec');
        }
        $activityId = array_shift($inputs);

        $activity = $this->entityManager
            ->getRepository('Facturizer\Entity\Activity')
            ->findOneById($activityId);
        if (!$activity) {
            throw new RuntimeException('Activity not found');
        }

        $timeSpec = array_shift($inputs);

        $hoursSpentBefore = $activity->getHoursSpent();
        $activity->addHoursSpent($timeSpec);
        $this->entityManager->flush();

        Cursor::colorize('fg(green)');
        echo sprintf('Time spent for activity "%s" is now at %sh (Before: %sh)', $activity->getName(), $activity->getHoursSpent(), $hoursSpentBefore), PHP_EOL;
    }

    public function getDescription()
    {
        return 'Increases the time spent on an activity';
    }
}
