<?php

namespace Facturizer\Command;

/**
 * Command\ListProjects
 */
class ListProjects
{
    public function __invoke()
    {
        echo 'Test';
    }

    public function getKey()
    {
        return 'list-projects';
    }
}
