<?php

/**
 * Menu builder service
 */

namespace Module7\MenuBundle\Menu;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

class MenuBuilder
{
    protected $requestStack;
    protected $router;

    protected $menu;
    protected $rootContainer;

    public function __construct(
        RequestStack $requestStack,
        Router $router,
        array $options = array())
    {
        $this->requestStack = $requestStack;
        $this->router = $router;
        $this->options = $options;

        // Initialize the menu
        $this->menu = $this->createMenu($options);

        // Initialize the root container of the menu
        $this->rootContainer = new MenuItem();
        $this->menu->setRootContainer($this->rootContainer);
    }

    /**
     * Creates the Menu
     *
     * @return Module7\MenuBundle\Menu\Menu
     */
    public function getMenu()
    {
        // Before we return the menu, set the active trail
        $this->menu->setActiveTrail($this->requestStack);

        return $this->menu;
    }

    /**
     * Creates a new menu item and adds it to the main container
     *
     * @return Module7\MenuBundle\Menu\MenuBuilder
     */
    public function newMenuItem($options)
    {
        $menuItem = new MenuItem($options);
        $this->rootContainer->add($menuItem);

        return $this;
    }

    protected function createMenu(array $options = array())
    {
        $menu = new Menu();

        if (isset($options['name'])) {
            $menu->setName($options['name']);
        }

        $translationDomain = isset($options['translation_domain'])
            ? $options['translation_domain']
            : 'menu';

        if (isset($options['attributes'])) {
            $menu->setAttributes($options['attributes']);
        }

        return $menu;
    }
}