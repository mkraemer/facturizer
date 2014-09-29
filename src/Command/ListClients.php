<?php

namespace Facturizer\Command;

use Hoa\Console\Cursor;
use Facturizer\TextHelper,
    Facturizer\Storage\ObjectStorage;
/**
 * Command\ListClients
 */
class ListClients
{
    protected $clientStorage;

    public function __construct(ObjectStorage $clientStorage)
    {
        $this->clientStorage = $clientStorage;
    }

    public function __invoke()
    {
        $clients = $this->clientStorage->get();

        if (empty($clients)) {
            Cursor::colorize('fg(yellow)');
            echo 'You have no active clients' . PHP_EOL;
            return;
        }

        $data = [['Handle', 'Client', 'Template']];
        foreach ($clients as $client) {
            $data[] = [$client->getHandle(), $client->getName(), $client->getTemplateName()];
        }

        echo TextHelper::buildTable($data);
    }

    public function getDescription()
    {
        return 'Lists all active clients';
    }
}
