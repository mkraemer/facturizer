<?php

namespace Facturizer\Service;

/**
 * Facturizer\Service\HandleService
 */
class HandleService
{
    private function findFreeHandle($existingObjects, $objectClass)
    {
        $usedHandles = [];

        foreach ($existingObjects as $client) {
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

    public function assignHandle($allObjects, $newObject)
    {
        $objectClass = get_class($newObject);

        $handle = $this->findFreeHandle($allObjects, $objectClass);

        $newObject->setHandle($handle);
    }
}
