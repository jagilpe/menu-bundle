<?php

namespace Jagilpe\MenuBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Jagilpe\MenuBundle\DependencyInjection\Compiler\MenuProviderPass;

/**
 * This Bundle builds a reusable Menu Service infrasstructure
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class JagilpeMenuBundle extends Bundle
{
    /**
     *
     * {@inheritDoc}
     * @see \Symfony\Component\HttpKernel\Bundle\Bundle::build()
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new MenuProviderPass());
    }
}