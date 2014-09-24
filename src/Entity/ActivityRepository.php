<?php

namespace Facturizer\Entity;

use Doctrine\ORM\EntityRepository;
use Facturizer\Entity\Client;

/**
 * Facturizer\Entity\ActivityRepository
 */
class ActivityRepository extends EntityRepository
{
    public function findBillableActivities(Client $client)
    {
        $query = $this->_em
            ->createQueryBuilder()
            ->select('a, p')
            ->from('Facturizer\Entity\Activity', 'a')
            ->leftJoin('a.project', 'p')
            ->where('a.isBillable = true')
            ->andWhere('a.isBilled = false')
            ->getQuery();

        $activities = $query->getResult();

        return $activities;
    }
}
