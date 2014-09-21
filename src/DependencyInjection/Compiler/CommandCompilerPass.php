<?php


namespace Facturizer\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class CommandCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('facturizer.registry.command_registry')) {
            return;
        }

        $definition = $container->getDefinition(
            'facturizer.registry.command_registry'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'facturizer.command'
        );

        foreach ($taggedServices as $id => $tagAttributes) {
            foreach ($tagAttributes as $attributes) {
                $definition->addMethodCall(
                    'add',
                    array(new Reference($id), $attributes['alias'])
                );
            }
        }
    }
}
