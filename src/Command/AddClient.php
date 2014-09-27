<?php

namespace Facturizer\Command;

use Hoa\Console\Cursor;
use Facturizer\Entity\Client,
    Facturizer\Exception\InvalidSyntaxException,
    Facturizer\Storage\ObjectStorage;

/**
 * Facturizer\Command\AddClient
 */
class AddClient
{
    protected $clientStorage;

    public function __construct(ObjectStorage $clientStorage)
    {
        $this->clientStorage = $clientStorage;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) != 4) {
            throw new InvalidSyntaxException('Parameters for this command: client-name hourly-rate currency-sign template-name');
        }

        $client = new Client();

        $client->setName(array_shift($inputs));
        $client->setHourlyRate(array_shift($inputs));
        $client->setCurrency(array_shift($inputs));
        $client->setTemplateName(array_shift($inputs));

        $this->handleService->assignHandle($client);
        $this->clientStorage->add($client);

        Cursor::colorize('fg(green)');
        echo 'Client created with handle ' . $client->getHandle() . PHP_EOL;
    }

    public function getDescription()
    {
        return 'Creates a new client';
    }
}
