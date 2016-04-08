<?php
/**
 * Menu builder factory
 */

namespace Module7\MenuBundle\Factory;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Module7\MenuBundle\Menu\MenuBuilder;

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
}