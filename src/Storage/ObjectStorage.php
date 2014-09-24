<?php

namespace Facturizer\Storage;

use Symfony\Component\Filesystem\Filesystem;
use JMS\Serializer\Serializer;
use Facturizer\Service\HandleService;

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

    protected $handleService;

    public function __construct(Filesystem $filesystem, Serializer $serializer, HandleService $handleService, $storagePath, $objectNamespace, $key)
    {
        $this->filesystem = $filesystem;

        $this->objectNamespace = $objectNamespace;

        $this->serializer = $serializer;

        $this->handleService = $handleService;

        $this->filePath = self::expandTilde($storagePath . '/' . $key . '.json');

        if ($this->filesystem->exists($this->filePath)) {
            $content = file_get_contents($this->filePath);
            $this->objects = $this->serializer->deserialize($content, 'array<'.$this->objectNamespace.'>', 'json');
        }
    }

    static function expandTilde($path)
    {
        if (function_exists('posix_getuid') && strpos($path, '~') !== false) {
            $info = posix_getpwuid(posix_getuid());
            $path = str_replace('~', $info['dir'], $path);
        }

    return $path;
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
        $this->handleService->assignHandle($this->objects, $object);

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
