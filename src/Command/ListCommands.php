<?php

namespace Facturizer\Command;

use Hoa\Console\Cursor;
use Facturizer\Registry\CommandRegistry,
    Facturizer\TextHelper;

/**
 * Facturizer\Command\ListCommands
 */
class ListCommands
{
    protected $commandRegistry;

    public function __construct(CommandRegistry $commandRegistry)
    {
        $this->commandRegistry = $commandRegistry;
    }

    public function __invoke()
    {
        Cursor::colorize('fg(yellow)');
        echo 'You can use the following commands:' . PHP_EOL;

        Cursor::colorize('fg(white)');
        $commands = $this->commandRegistry->getAll();
        ksort($commands);

        $data = [['Command', 'Description']];
        foreach ($commands as $alias => $command) {
            $data[] = [$alias, $command->getDescription()];
        }

        echo TextHelper::buildTable($data);
    }

    public function getDescription()
    {
        return 'Lists all commands';
    }
}
