<?php

namespace Module7\MenuBundle\Provider;

use Module7\MenuBundle\Menu\Menu;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 *
 */
interface MenuProviderInterface
{
    /**
     * Returns a menu object
     *
     * @param string $menuName
     *
     * @throws RuntimeException
     *
     * @return \Module7\Menu\Menu
     */
    public function getMenu($menuName);
}