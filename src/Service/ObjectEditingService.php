<?php

namespace Facturizer\Service;

use Symfony\Component\Filesystem\Filesystem;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializationContext;
use Facturizer\ExistingObjectConstructor;

/**
 * Facturizer\Service\ObjectEditingService
 */
class ObjectEditingService
{
    protected $filesystem;

    protected $serializer;

    protected $note = <<<EOT
# Below is a representation of..
# Serialized in the yaml format.
#
# To abort this, exit your editor without saving or making changes to this file.
#
# Modify what you wish - after saving your changes will be adopted.
#
#
# A backup of the original state has been saved at XXX
# Should you find yourself in a position

EOT;

    public function __construct(Filesystem $filesystem, Serializer $serializer)
    {
        $this->filesystem = $filesystem;

        $this->serializer = $serializer;
    }

    public function edit(&$object)
    {
        $objectNamespace = get_class($object);

        $serializer = \JMS\Serializer\SerializerBuilder::create()
            ->setObjectConstructor(
                //Wrapper: First ExistingObjectConstructor,
                //then Unserializing, ...
                new ExistingObjectConstructor($object)
            )
            ->build();

        $originalYaml = $serializer->serialize($object, 'yml');

        edit:
        $fileName = tempnam(sys_get_temp_dir(), 'yaml');

        $this->filesystem->dumpFile($fileName, $this->note . $originalYaml);

        system("vim $fileName > `tty`");

        $editedYaml = file_get_contents($fileName);
        if ($originalYaml == $editedYaml) {
            echo 'No changes detected' . PHP_EOL;
            return $object;
        }

        $done = false;
        while (!$done) {
            try {
                $serializer->deserialize($editedYaml, $objectNamespace, 'yml');
            } catch (\Exception $e) {
                goto edit;
            }

            $done = true;
        }
    }
}
