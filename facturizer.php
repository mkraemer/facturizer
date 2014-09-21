<?php

include __DIR__.'/vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Facturizer\DependencyInjection\Compiler\CommandCompilerPass;

$container = new ContainerBuilder();
$container->addCompilerPass(new CommandCompilerPass());
$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/config'));
$loader->load('services.yml');
$container->compile();

$parser = new Hoa\Console\Parser();
$parser->parse(Hoa\Router\Cli::getURI());

$switches = $parser->getSwitches();
$inputs = $parser->getInputs();

if (empty($inputs)) {
    $inputs[] = 'project-list';
}

$commandRegistry = $container->get('facturizer.registry.command_registry');
$command = $commandRegistry->getByKey(array_shift($inputs));
$command();
