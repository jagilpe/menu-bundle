<?php

namespace Module7\MenuBundle\Factory;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Module7\MenuBundle\Menu\MenuBuilder;
use Module7\MenuBundle\Menu\MenuItem;

/**
 * Menu builder factory
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class MenuBuilderFactory
{
    private $requestStack;
    private $router;

    public function __construct(
        RequestStack $requestStack,
        Router $router)
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

    /**
     * Creates a new empty Menu
     */
    public function createMenuBuilder(array $options = array())
    {
        return new MenuBuilder($this->requestStack, $this->router, $options);
    }

    /**
     * Creates a new Menu Item
     *
     * @param array $options
     *
     * @return \Module7\MenuBundle\Menu\MenuItem
     */
    public function createMenuItem(array $options = array())
    {
        $menuItem = new MenuItem($options);

        return $menuItem;
    }
}