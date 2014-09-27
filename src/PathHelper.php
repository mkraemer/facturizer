<?php

namespace Facturizer;

/**
 * Facturizer\PathHelper
 */
class PathHelper
{
    public function getPath($path)
    {
        /**
         * expand tilde:
         */
        if (function_exists('posix_getuid') && strpos($path, '~') !== false) {
            $info = posix_getpwuid(posix_getuid());
            $path = str_replace('~', $info['dir'], $path);
        }

        return $path;
    }
}
