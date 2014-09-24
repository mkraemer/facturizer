<?php

namespace Facturizer\Storage;

use Symfony\Component\Filesystem\Filesystem;
use JMS\Serializer\Serializer;

/**
 * Facturizer\Storage\ObjectStorage
 */
class ObjectStorage
{
    protected $filesystem;

    protected $objectNamespace;

    protected $filePath;

    protected $serializer;

    protected $objects = [];

    public function __construct(Filesystem $filesystem, Serializer $serializer, $storagePath, $objectNamespace, $key)
    {
        $this->filesystem = $filesystem;

        $this->objectNamespace = $objectNamespace;

        //$this->serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $this->serializer = $serializer;

        $this->filePath = $storagePath . '/' . $key . '.json';

        if ($this->filesystem->exists($this->filePath)) {
            $content = file_get_contents($this->filePath);
            $this->objects = $this->serializer->deserialize($content, 'array<'.$this->objectNamespace.'>', 'json');
        }
    }

    public function get(callable $filter = null)
    {
        if (!empty($filter)) {
             return array_filter($this->objects, $filter);
        }

        return $this->objects;
    }

    public function getOne(callable $filter)
    {
        $results = $this->get($filter);

        return array_shift($results);
    }

    public function add($object)
    {
        $object->setId(uniqid());

        $this->objects[] = $object;
    }

    public function __destruct()
    {
        if (empty($this->objects)) {
            return;
        }

        $content = $this->serializer->serialize($this->objects, 'json');

        $this->filesystem->dumpFile($this->filePath, $content);
    }
}
