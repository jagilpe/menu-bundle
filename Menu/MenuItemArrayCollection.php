<?php

namespace Module7\MenuBundle\Menu;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Menu Item Collection backed up by a Doctrine\Common\Collections\ArrayCollection
 * The reason why we implement this wrapping class around the ArrayCollection class
 * is the need of type check, but we don't have an equivalent to the Java generics
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class MenuItemArrayCollection implements MenuItemCollection
{
    /**
     * The ArrayCollection that backs all the functionality
     *
     * @var Doctrine\Common\Collections\ArrayCollection
     */
    protected $collection;

    /**
     * Initializes the MenuItemArrayCollection
     */
    public function __construct()
    {
        $this->collection = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function add(MenuItem $menu_item)
    {
        $this->collection->add($menu_item);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->collection->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function contains(MenuItem $menu_item)
    {
        return $this->collection->contains($menu_item);
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty()
    {
        return $this->collection->isEmpty();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($key)
    {
        return $this->collection->remove($key);
    }

    /**
     * {@inheritdoc}
     */
    public function removeElement($menu_item)
    {
        return $this->collection->removeElement($menu_item);
    }

    /**
     * {@inheritdoc}
     */
    public function containsKey($key)
    {
        return $this->collection->containsKey($key);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key)
    {
        return $this->collection->get($key);
    }

    /**
     * {@inheritdoc}
     */
    public function getKeys()
    {
        return $this->collection->getKeys();
    }

    /**
     * {@inheritdoc}
     */
    public function getValues()
    {
        return $this->collection->getValues();
    }

    /**
     * {@inheritdoc}
     */
    public function set($key, $value)
    {
        return $this->collection->set($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->collection->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function first()
    {
        return $this->collection->first();
    }

    /**
     * {@inheritdoc}
     */
    public function last()
    {
        return $this->collection->last();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->collection->key();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->collection->current();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        return $this->collection->next();
    }

    /**
     * {@inheritdoc}
     */
    public function exists(\Closure $p)
    {
        return $this->collection->exists($p);
    }

    /**
     * {@inheritdoc}
     */
    public function filter(\Closure $p)
    {
        return $this->collection->filter($p);
    }

    /**
     * {@inheritdoc}
     */
    public function forAll(\Closure $p)
    {
        return $this->collection->forAll($p);
    }

    /**
     * {@inheritdoc}
     */
    public function map(\Closure $func)
    {
        return $this->collection->map($p);
    }

    /**
     * {@inheritdoc}
     */
    public function partition(\Closure $p)
    {
        return $this->collection->partition($p);
    }

    /**
     * {@inheritdoc}
     */
    public function indexOf($menu_item)
    {
        return $this->collection->indexOf($menu_item);
    }

    /**
     * {@inheritdoc}
     */
    public function slice($offset, $length = null)
    {
        return $this->collection->slice($offset, $length = null);
    }

    /**
     * {@inheritdoc}
     */
    public function addElements(MenuItemCollection $collection)
    {

        $collection->first();
        while ($menu_item = $collection->next()) {
            $this->collection->add($menu_item);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMenuItems()
    {
        return $this->toArray();
    }

}