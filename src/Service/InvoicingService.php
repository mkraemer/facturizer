<?php

namespace Facturizer\Service;

use Doctrine\ORM\EntityManager;
use Facturizer\Entity\Client,
    Facturizer\Entity\Invoice,
    Facturizer\Entity\Post;

/**
 * Facturizer\Service\InvoicingService
 */
class InvoicingService
{
    protected $twig;

    public function __construct($twig)
    {
        $this->twig = $twig;
    }

    public function buildInvoice(Client $client, $invoiceId)
    {
        $invoice = new Invoice($invoiceId, $client->getCurrency());

        $invoiceTotal = 0;
        foreach ($client->getProjects() as $project) {
            foreach ($project->getActivities() as $activity) {
                if ($activity->getHoursSpent() == 0 || !$activity->isBillable()) {
                    continue;
                }

                $postTotal = $activity->getHoursSpent() * $client->getHourlyRate();
                $post = new Post(
                    $activity->getName(),
                    $project->getName(),
                    $activity->getHoursSpent(),
                    $client->getHourlyRate(),
                    $postTotal
                );
                $invoice->addPost($post);
                $invoiceTotal += $postTotal;
                //$activity->setInvoiceId($invoice->getId());
            };
        }
        $invoice->setTotal($invoiceTotal);

        echo $this->twig->render($client->getTemplateName(), ['invoice' => $invoice, 'client' => $client]);
    }
}
