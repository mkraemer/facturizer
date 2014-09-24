<?php

namespace Facturizer\Command;

use RuntimeException;
use Doctrine\ORM\EntityManager;
use Hoa\Console\Cursor;
use Facturizer\Entity\Activity,
    Facturizer\Service\InvoicingService,
    Facturizer\Exception\InvalidSyntaxException;

/**
 * Facturizer\Command\CreateInvoice
 */
class CreateInvoice
{
    protected $entityManager;

    protected $invoicingService;

    public function __construct(EntityManager $entityManager, InvoicingService $invoicingService)
    {
        $this->entityManager = $entityManager;

        $this->invoicingService = $invoicingService;
    }

    public function __invoke($inputs, $switches)
    {
        if (count($inputs) != 1) {
            throw new InvalidSyntaxException('Parameters for this command: client-id');
        }

        Cursor::colorize('fg(yellow)');

        $clientId = array_shift($inputs);
        $clientEntityRepository = $this->entityManager
            ->getRepository('Facturizer\Entity\Client');
        $client = $clientEntityRepository->findOneById($clientId);

        if (!$client) {
            throw new RuntimeException('Client not found');
        }

        $this->invoicingService->buildInvoice($client);
    }

    public function getDescription()
    {
        return 'Creates an invoice for a client';
    }
}
