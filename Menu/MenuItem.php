<?php

namespace Module7\MenuBundle\Menu;

/**
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class MenuItem extends MenuItemArrayCollection
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $nameParams = array();

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $route;

    /**
     * @var array
     */
    protected $routeParams = array();

    /**
     * @var array
     */
    protected $routeOptions = array('anchor' => false);

    /**
     * @var boolean
     */
    protected $active;

    /**
     * @var boolean
     */
    protected $disabled;

    /**
     * @var boolean
     */
    protected $hideChildren;

    /**
     * @var array
     */
    protected $attributes;

    /**
     * Initializes the MenuItem
     */
    public function __construct($options = array())
    {
        parent::__construct();

        // Set the default values
        $this->description = isset($options['description']) ? $options['description'] : null;
        $this->route = isset($options['route']) ? $options['route'] : null;
        $this->routeParams = isset($options['route_params']) ? $options['route_params'] : array();
        $this->name = isset($options['name']) ? $options['name'] : null;
        $this->attributes = isset($options['attributes']) ? $options['attributes'] : null;
        $this->active = isset($options['active']) ? $options['active'] : false;
        $this->disabled = isset($options['disabled']) ? $options['disabled'] : false;
        $this->hideChildren = isset($options['hide_children']) ? $options['hide_children'] : false;
    }

    /**
     * Returns the name of the item
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name of the menu item
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the description of the item
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description of the menu item
     *
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Returns the destination link of the item
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Sets the destination route of the menu item
     *
     * @param string $route
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Returns the options for the destination link of the item
     *
     * @return array
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }

    /**
     * Sets the params for the destination route of the menu item
     *
     * @param array $route_params
     */
    public function setRouteParams($route_params)
    {
        $this->routeParams = $route_params;

        return $this;
    }

    /**
     * Returns the options for the destination link of the item
     *
     * @return string
     */
    public function getRouteOptions()
    {
        return $this->routeOptions;
    }

    /**
     * Sets the options for the destination route of the menu item
     *
     * @param string $route
     */
    public function setRouteOptions($route_options)
    {
        $this->routeOptions = $route_options;

        return $this;
    }

    /**
     * Returns if this menu item is active
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * Sets the active status link of the menu item
     *
     * @param boolean $active
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Returns if this menu item is disabled
     */
    public function isDisabled()
    {
        return $this->disabled;
    }

    /**
     * Sets the disable status link of the menu item
     *
     * @param string $link
     */
    public function setDisabled($disabled)
    {
        $this->disabled = $disabled;

        return $this;
    }

    /**
     * Returns if we have to hide the childrens of this menu item
     */
    public function isHideChildren()
    {
        return $this->hideChildren;
    }

    /**
     * Sets the disable status link of the menu item
     *
     * @param string $hide_children
     */
    public function setHideChildren($hide_children)
    {
        $this->hideChildren = $hide_children;

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
     * Gets the active route from the request stack and sets this item as
     * active if it's equal to the route of the item or any of its children
     *
     * @param array $routes
     * @return boolean
     */
    public function setActiveTrail($routes)
    {
        $active = false;

        if (in_array($this->getRoute(), $routes)) {
            $active = true;

            $this->addAttribute('class', 'active');
        }
        else {
            // Check if any of the children of the menu item is the active one
            foreach ($this->toArray() as $child) {
                $active = $active || $child->setActiveTrail($routes);
            }
        }

        $this->setActive($active);

        return $active;
    }

    /**
     * Returns the active element of the menu item or the first if no one is active
     *
     * @return
     */
    public function getActiveChild()
    {
        $found = false;

        $menu_item = $this->first();
        while(!$found && $menu_item) {
            if ($menu_item->isActive()) {
                $active_menu_item = $menu_item;
                $found = true;
            }

            $menu_item = $this->next();
        }

        return $found ? $active_menu_item : $this->first();
    }

    public function getNameParams()
    {
        return $this->nameParams;
    }

    public function setNameParams(array $name_params)
    {
        $this->nameParams = $name_params;
        return $this;
    }

}
