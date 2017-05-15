<?php

namespace Jagilpe\MenuBundle\Provider;

use Jagilpe\MenuBundle\Factory\MenuBuilderFactory;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
interface MenuProviderFactoryAwareInterface
{
    /**
     * Injects the Menu Builder Factory
     *
     * @param MenuBuilderFactory $menuFactory
     */
    public function setMenuFactory(MenuBuilderFactory $menuFactory);
}