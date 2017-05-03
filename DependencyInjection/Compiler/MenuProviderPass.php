<?php

namespace Jagilpe\MenuBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class MenuProviderPass implements CompilerPassInterface
{
    /**
     *
     * {@inheritDoc}
     * @see \Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {
        // Check if the list factory is defined
        if (!$container->has('jgp_menu.twig_extension')) {
            return;
        }

        $definition = $container->findDefinition('jgp_menu.twig_extension');

        $taggedServices = $container->findTaggedServiceIds('jgp_menu.service_provider');

        foreach ($taggedServices as $id => $tags) {
            $definition->addMethodCall('addMenuProvider', array(new Reference($id)));
        }
    }
}