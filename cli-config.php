<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once 'facturizer.php';

$entityManager = $container->get('doctrine.orm.entity_manager');

return ConsoleRunner::createHelperSet($entityManager);
