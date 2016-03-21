<?php

namespace Module7\MenuBundle\Util\Menu;

use Symfony\Component\HttpFoundation\RequestStack;

/**
 *
 */
class Menu
{

    /**
     * @var Module7\CommonsBundle\Util\Menu\MenuItemCollection
     */
    private $rootContainer;

    /**
     * The name of the Menu
     *
     * @var string
     */
    protected $name;

    protected $attributes;

    protected $translationDomain = 'menu';

    /**
     * Returns the root container of the menu
     *
     * @return Module7\CommonsBundle\Util\Menu\MenuItemCollection
     */
    public function getRootContainer()
    {
        return $this->rootContainer;
    }

    /**
     * Sets the root container of the menu
     *
     * @param Module7\CommonsBundle\Util\Menu\MenuItemCollection $root_container
     */
    public function setRootContainer(MenuItemCollection $root_container)
    {
        $this->rootContainer = $root_container;

        return $this;
    }

    /**
     * Returns the name of the menu
     *
     * @return string
     */
    public function getName()
    {
        return $name;
    }

    /**
     * Sets the name of the menu
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    public function addAttribute($name, $value)
    {

        if (isset($this->attributes[$name])) {
            if (!is_array($this->attributes[$name])) {
                $this->attributes[$name] = array($this->attributes[$name]);

            }
            $this->attributes[$name][] = $value;
        }
        else {
            $this->attributes[$name] = $value;
        }

        return $this;
    }

    /**
     * Finds the active element of the menu from the current route and sets the correspondant
     * active trail
     *
     * @param Symfony\Component\HttpFoundation\RequestStack $request_stack
     * The route that is active in this moment
     */
    public function setActiveTrail(RequestStack $request_stack)
    {

        $request_stack_copy = clone $request_stack;
        // Get the route from the request stack
        $routes = array();
        while ($request = $request_stack_copy->pop()) {
            if ($route = $request->get('_route')) {
                $routes[] = $route;
            }
        }

        // Sets the active trail in the children of the rootcontainer
        $this->getRootContainer()->setActiveTrail($routes);
    }

    public function getTranslationDomain()
    {
        return $this->translationDomain;
    }

    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
        return $this;
    }


}