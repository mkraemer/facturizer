<?php

namespace Facturizer\Registry;

use Facturizer\Exception\CommandNotFoundException;

/**
 * Facturizer\Registry\CommandRegistry
 */
class CommandRegistry
{
    protected $commands = [];

    public function getByKey($key)
    {
        if (!array_key_exists($key, $this->commands)) {
            throw new CommandNotFoundException();
        }

        return $this->commands[$key];
    }

    public function add(callable $command, $alias)
    {
        $this->commands[$alias] = $command;
    }
}
