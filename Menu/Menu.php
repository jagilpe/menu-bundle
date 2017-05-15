<?php

namespace Jagilpe\MenuBundle\Menu;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class Menu
{
    /**
     * @var string
     */
    private $homeRoute;

    /**
     * @var MenuItemCollection
     */
    private $rootContainer;

    /**
     * The name of the Menu
     *
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * @var string
     */
    protected $translationDomain = 'menu';

    /**
     * @var string[]
     */
    protected $activeTrail;

    /**
     * Returns the root container of the menu
     *
     * @return MenuItemCollection
     */
    public function getRootContainer()
    {
        return $this->rootContainer;
    }

    /**
     * Sets the root container of the menu
     *
     * @param MenuItemCollection $rootContainer
     *
     * @return Menu
     */
    public function setRootContainer(MenuItemCollection $rootContainer)
    {
        $this->rootContainer = $rootContainer;

        return $this;
    }

    /**
     * Returns the name of the route that will be set as home page
     *
     * @return string
     */
    public function getHomeRoute()
    {
        return $this->homeRoute;
    }

    /**
     * Returns the name of the route that will be set as home page
     *
     * @param string $homeRoute
     * 
     * @return Menu
     */
    public function setHomeRoute($homeRoute)
    {
        $this->homeRoute = $homeRoute;
        return $this;
    }

    /**
     * Returns the name of the menu
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the menu
     *
     * @param string $name
     * @return Menu
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return Menu
     */
    public function setAttributes(array $attributes = array())
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string $name
     * @param mixed $value
     * @return Menu
     */
    public function addAttribute($name, $value)
    {

        if (isset($this->attributes[$name])) {
            if (!is_array($this->attributes[$name])) {
                $this->attributes[$name] = array($this->attributes[$name]);

            }
            $this->attributes[$name][] = $value;
        } else {
            $this->attributes[$name] = $value;
        }

        return $this;
    }

    /**
     * Finds the active element of the menu from the current route and sets the correspondant
     * active trail
     *
     * @param RequestStack $requestStack
     * The route that is active in this moment
     */
    public function setActiveTrail(RequestStack $requestStack)
    {
        $requestStackCopy = clone $requestStack;
        // Get the route from the request stack
        $this->activeTrail = array();
        $routesData = array();
        while ($request = $requestStackCopy->pop()) {
            if ($route = $request->get('_route')) {
                $this->activeTrail[] = array(
                    'route' => $route,
                    'route_params' => $request->get('_route_params'),
                );
            }
        }

        // Sets the active trail in the children of the rootcontainer
        $this->getRootContainer()->setActiveTrail($this->activeTrail);
    }

    /**
     * Returns the active trail
     *
     * @return string[]
     */
    public function getActiveTrail()
    {
        return $this->activeTrail;
    }

    /**
     * @return string
     */
    public function getTranslationDomain()
    {
        return $this->translationDomain;
    }

    /**
     * @param string $translationDomain
     * @return Menu
     */
    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
        return $this;
    }

}