<?php

namespace Module7\MenuBundle\Menu;

interface MenuItemCollection
{

    /**
     * Adds menu item at the end of the collection.
     *
     * @param Module7\MenuBundle\Menu\MenuItem $menu_item The menu item to add.
     *
     * @return boolean Always TRUE.
     */
    public function add(MenuItem $menu_item);

    /**
     * Clears the collection, removing all menu item.
     *
     * @return void
     */
    public function clear();

    /**
     * Checks whether menu item is contained in the collection.
     * This is an O(n) operation, where n is the size of the collection.
     *
     * @param Module7\MenuBundle\Menu\MenuItem $menu_item The element to search for.
     *
     * @return boolean TRUE if the collection contains the menu item, FALSE otherwise.
     */
    public function contains(MenuItem $menu_item);

    /**
     * Checks whether the collection is empty (contains no menu items).
     *
     * @return boolean TRUE if the collection is empty, FALSE otherwise.
     */
    public function isEmpty();

    /**
     * Removes the menu item at the specified index from the collection.
     *
     * @param string|integer $key The kex/index of the menu item to remove.
     *
     * @return Module7\MenuBundle\Menu\MenuItem The removed menu item or NULL,
     *  if the collection did not contain the element.
     */
    public function remove($key);

    /**
     * Removes the specified menu item from the collection, if it is found.
     *
     * @param Module7\MenuBundle\Menu\MenuItem $menu_item The menu item to remove.
     *
     * @return boolean TRUE if this collection contained the specified menu item, FALSE otherwise.
     */
    public function removeElement($menu_item);

    /**
     * Checks whether the collection contains a menu item with the specified key/index.
     *
     * @param string|integer $key The key/index to check for.
     *
     * @return boolean TRUE if the collection contains an menu item with the specified key/index,
     *                 FALSE otherwise.
     */
    public function containsKey($key);

    /**
     * Gets the menu item at the specified key/index.
     *
     * @param string|integer $key The key/index of the menu item to retrieve.
     *
     * @return Module7\MenuBundle\Menu\MenuItem
     */
    public function get($key);

    /**
     * Gets all keys/indices of the collection.
     *
     * @return array The keys/indices of the collection, in the order of the corresponding
     *               menu items in the collection.
     */
    public function getKeys();

    /**
     * Gets all values of the collection.
     *
     * @return array The values of all menu item in the collection, in the order they
     *               appear in the collection.
     */
    public function getValues();

    /**
     * Sets an menu item in the collection at the specified key/index.
     *
     * @param string|integer $key   The key/index of the menu item to set.
     * @param Module7\MenuBundle\Menu\MenuItem  $value The menu item to set.
     *
     * @return void
     */
    public function set($key, $value);

    /**
     * Gets a native PHP array representation of the collection.
     *
     * @return array
     */
    public function toArray();

    /**
     * Sets the internal iterator to the first menu item in the collection and returns this menu item.
     *
     * @return Module7\MenuBundle\Menu\MenuItem
     */
    public function first();

    /**
     * Sets the internal iterator to the last menu item in the collection and returns this menu item.
     *
     * @return Module7\MenuBundle\Menu\MenuItem
     */
    public function last();

    /**
     * Gets the key/index of the menu item at the current iterator position.
     *
     * @return int|string
     */
    public function key();

    /**
     * Gets the menu item of the collection at the current iterator position.
     *
     * @return Module7\MenuBundle\Menu\MenuItem
     */
    public function current();

    /**
     * Moves the internal iterator position to the next menu item and returns this menu item.
     *
     * @return Module7\MenuBundle\Menu\MenuItem
     */
    public function next();

    /**
     * Tests for the existence of a menu item that satisfies the given predicate.
     *
     * @param \Closure $p The predicate.
     *
     * @return boolean TRUE if the predicate is TRUE for at least one element, FALSE otherwise.
     */
    public function exists(\Closure $p);

    /**
     * Returns all the menu item of this collection that satisfy the predicate p.
     * The order of the menu items is preserved.
     *
     * @param \Closure $p The predicate used for filtering.
     *
     * @return Collection A collection with the results of the filter operation.
     */
    public function filter(\Closure $p);

    /**
     * Tests whether the given predicate p holds for all menu item of this collection.
     *
     * @param \Closure $p The predicate.
     *
     * @return boolean TRUE, if the predicate yields TRUE for all menu item, FALSE otherwise.
     */
    public function forAll(\Closure $p);

    /**
     * Applies the given function to each menu item in the collection and returns
     * a new collection with the menu item returned by the function.
     *
     * @param \Closure $func
     *
     * @return Collection
     */
    public function map(\Closure $func);

    /**
     * Partitions this collection in two collections according to a predicate.
     * Keys are preserved in the resulting collections.
     *
     * @param \Closure $p The predicate on which to partition.
     *
     * @return array An array with two element. The first elemnt contains the collection
     *               of menu items where the predicate returned TRUE, the second element
     *               contains the collection of menu item where the predicate returned FALSE.
     */
    public function partition(\Closure $p);

    /**
     * Gets the index/key of a given menu item. The comparison of two menu item is strict,
     * that means not only the value but also the type must match.
     * For objects this means reference equality.
     *
     * @param Module7\MenuBundle\Menu\MenuItem $menu_item The menu item to search for.
     *
     * @return int|string|bool The key/index of the menu item or FALSE if the menu item was not found.
     */
    public function indexOf($menu_item);

    /**
     * Extracts a slice of $length menu items starting at position $offset from the Collection.
     *
     * If $length is null it returns all menu items from $offset to the end of the Collection.
     * Keys have to be preserved by this method. Calling this method will only return the
     * selected slice and NOT change the menu items contained in the collection slice is called on.
     *
     * @param int      $offset The offset to start from.
     * @param int|null $length The maximum number of menu items to return, or null for no limit.
     *
     * @return array
     */
    public function slice($offset, $length = null);

    /**
     * Adds all the MenuItems of the collection at the end
     *
     * @param MenuItemCollection $collection
     */
    public function addElements(MenuItemCollection $collection);

    /**
     * Alias of toArray to be able to use it in twig templates
     *
     * @return array
     */
    public function getMenuItems();
}
