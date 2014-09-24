<?php

namespace Facturizer\Service;

use Doctrine\ORM\EntityManager;
use Facturizer\Entity\Client,
    Facturizer\Entity\Invoice;

/**
 * Facturizer\Service\InvoicingService
 */
class InvoicingService
{
    protected $entityManager;

    protected $twig;

    public function __construct(EntityManager $entityManager, $twig)
    {
        $this->entityManager = $entityManager;

        $this->twig = $twig;
    }

    public function buildInvoice(Client $client)
    {
        $billableActivities = $this->entityManager
            ->getRepository('Facturizer\Entity\Activity')
            ->findBillableActivities($client);

        $invoice = new Invoice();
        //@todo Get serial of last invoice, increment

        foreach ($billableActivities as $activity) {
            $invoice->getActivities()->add($activity);
        }

        echo $this->twig->render($client->getTemplateName(), ['invoice' => $invoice, 'client' => $client]);

        foreach ($billableActivities as $activity) {
            //$activity->setIsBilled($true);
        }
    }
}
