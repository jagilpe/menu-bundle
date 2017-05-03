<?php

namespace Jagilpe\MenuBundle\Provider;

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
     * @throws \RuntimeException
     *
     * @return \Jagilpe\MenuBundle\Menu\Menu
     */
    public function getMenu($menuName);
}