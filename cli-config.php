<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
require_once 'facturizer.php';

// replace with mechanism to retrieve EntityManager in your app
$entityManager = $container->get('doctrine.orm.entity_manager');

return ConsoleRunner::createHelperSet($entityManager);
