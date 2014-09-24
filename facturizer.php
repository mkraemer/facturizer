<?php

include __DIR__.'/vendor/autoload.php';

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Hoa\Console\Cursor;
use Facturizer\DependencyInjection\Compiler\CommandCompilerPass;
use Facturizer\Exception\CommandNotFoundException;
use Facturizer\Exception\InvalidSyntaxException;

$container = new ContainerBuilder();
$container->addCompilerPass(new CommandCompilerPass());
$loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/config'));
$loader->load('services.yml');
$container->compile();

mb_internal_encoding('UTF-8');

if ($argv[0] == 'vendor/bin/doctrine.php') {
    return;
}
\Doctrine\Common\Annotations\AnnotationRegistry::registerLoader('class_exists');

$parser = new Hoa\Console\Parser();
$parser->parse(Hoa\Router\Cli::getURI());
$switches = $parser->getSwitches();
$inputs = $parser->getInputs();

if (empty($inputs)) {
    $inputs[] = 'al';
} elseif (is_numeric($inputs[0])) {
    array_unshift($inputs, 'ab');
}

$commandRegistry = $container->get('facturizer.registry.command_registry');

try {
    $command = $commandRegistry->getByKey(array_shift($inputs));
} catch (CommandNotFoundException $e) {
    Cursor::colorize('fg(red)');
    echo 'This command was not found.' . PHP_EOL;

    Cursor::colorize('fg(yellow)');
    $helpCommand = $commandRegistry->getByKey('help');
    $helpCommand();
    exit(1);
}

try {
    $command($inputs, $switches);
} catch (InvalidSyntaxException $e) {
    Cursor::colorize('fg(red)');
    echo 'You tried to execute a command using an invalid syntax.' . PHP_EOL;

    Cursor::colorize('fg(yellow)');
    echo $e->getMessage() . PHP_EOL;
    exit(1);
} catch (RuntimeException $e) {
    Cursor::colorize('fg(red)');
    echo $e->getMessage() . PHP_EOL;
    exit(1);
}

exit(0);
