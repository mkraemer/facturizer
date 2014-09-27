<?php

namespace Facturizer\Service;

use Facturizer\Storage\ObjectStorage;

/**
 * Facturizer\Service\HandleService
 */
class HandleService
{
    protected $objectStorage;

    public function __construct(ObjectStorage $objectStorage)
    {
        $this->objectStorage = $objectStorage;
    }

    private function findFreeHandle($objectClass)
    {
        $usedHandles = [];

        foreach ($this->objectStorage->get() as $client) {
            if (get_class($client) == $objectClass) {
                $usedHandles[] = $client->getHandle();
            } else {
                foreach ($client->getProjects() as $project) {
                    if (get_class($project) == $objectClass) {
                        $usedHandles[] = $project->getHandle();
                    } else {
                        foreach ($project->getActivities() as $activity) {
                            $usedHandles[] = $activity->getHandle();
                        }
                    }
                }
            }
        }

        $handle = 1;
        while (in_array($handle, $usedHandles)) {
            $handle++;
        }

        return $handle;
    }

    public function assignHandle($newObject)
    {
        $handle = $this->findFreeHandle(get_class($newObject));

        $newObject->setHandle($handle);
    }
}
