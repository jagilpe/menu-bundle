<?php

namespace Jagilpe\MenuBundle\Provider;

use Jagilpe\MenuBundle\Factory\MenuBuilderFactory;

/**
 * Base class for implementing the MenuProviderInterface
 *
 * @author Javier Gil Pereda <javier@gilpereda.com>
 */
abstract class AbstractMenuProvider implements MenuProviderInterface, MenuProviderFactoryAwareInterface
{
    /**
     * @var MenuBuilderFactory
     */
    protected $menuFactory;

    /**
     * Injects the Menu Builder Factory
     * 
     * @param MenuBuilderFactory $menuFactory
     */
    public function setMenuFactory(MenuBuilderFactory $menuFactory)
    {
        $this->menuFactory = $menuFactory;
    }
}