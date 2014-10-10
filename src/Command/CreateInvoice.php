<?php

namespace Facturizer\Command;

use RuntimeException;
use Hoa\Console\Cursor;
use Facturizer\Entity\Activity,
    Facturizer\Service\InvoicingService,
    Facturizer\Storage\ObjectStorage,
    Facturizer\Exception\InvalidSyntaxException;

/**
 * Facturizer\Command\CreateInvoice
 */
class CreateInvoice
{
    protected $clientStorage;

    protected $invoicingService;

    public function __construct(ObjectStorage $clientStorage, InvoicingService $invoicingService)
    {
        $this->clientStorage = $clientStorage;

        $this->invoicingService = $invoicingService;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) != 2) {
            throw new InvalidSyntaxException('Parameters for this command: client-handle invoice-id');
        }

        $clientHandle = array_shift($inputs);
        $client = $this->clientStorage->getOne(function ($client) use ($clientHandle) {return ($client->getHandle() == $clientHandle);});

        if (!$client) {
            throw new RuntimeException('Client not found');
        }

        $this->invoicingService->buildInvoice($client, array_shift($inputs));
    }

    public function getDescription()
    {
        return 'Creates an invoice for a client';
    }
}
