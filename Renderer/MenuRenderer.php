<?php

namespace Module7\MenuBundle\Renderer;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Module7\MenuBundle\Menu\Menu;
use Module7\MenuBundle\Menu\MenuItem;

/**
 * This class is used to get a rendered menu using different templates and options
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class MenuRenderer
{
    const MENU_FULL = 'full';
    const MENU_SUBMENU = 'submenu';
    const MENU_SIDEBAR = 'sidebar';
    const MENU_CUSTOM = 'custom';

    private $templating;

    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }

    public function renderMenu(Menu $menu = null, $view = 'full', $options = array())
    {

        // Select the view to render
        switch ($view) {
            case self::MENU_FULL:
                return $this->renderFullMenu($menu, $options);
                break;
            case self::MENU_SUBMENU:
                $options += array(
                    'type' => 'pills',
                    'stacked' => false,
                    'level' => 1,
                    'classes' => array(),
                );
            case self::MENU_SIDEBAR:
                $options += array(
                    'type' => 'pills',
                    'stacked' => true,
                    'level' => 1,
                    'classes' => array(),
                );
                return $this->renderNLevelMenu($menu, $options['level'], $options);
                break;
            case self::MENU_CUSTOM:
                return $this->renderCustomMenu($menu, $options);
            default:
                throw new \RuntimeException('Menu view ' . $view . ' not supported.');
        }
    }

    /**
     * Returns a rendered block for a full functional menu
     *
     * @param Module7\MenuBundle\Menu\Menu
     */
    private function renderFullMenu(Menu $menu, $options = array())
    {
        // Set the default options
        $options += array(
            'id' => 'full-menu',
            'type' => 'normal',
            'justified' => false,
            'template' => 'Module7MenuBundle:Menu:navbar.html.twig',
        );

        $params = array(
            'id' => $options['id'],
        );

        return $this->templating->renderResponse(
            $options['template'],
            array('menu' => $menu, 'params' => $params)
        );
    }

    /**
     * Returns a renderd block for the first level elements of the menu
     *
     * @param Module7\MenuBundle\Menu\Menu
     */
    private function renderFirstLevelMenu(Menu $menu, $options = array())
    {
        return $this->nLevelMenu($menu, 1, $options);
    }

    /**
     * Returns a rendered block corresponding to the n-level of the menu
     *
     * @param Module7\MenuBundle\Menu\Menu $menu
     * @param integer $level
     */
    private function renderNLevelMenu(Menu $menu, $level, $options = array())
    {
        // Set the default options
        $options += array(
            'type' => 'pills',
            'stacked' => false,
            'justified' => false,
            'template' => 'Module7MenuBundle:Menu:nav.html.twig',
        );

        $ul_classes = array('nav');
        $ul_classes[] = $options['type'] == 'tabs' ? 'nav-tabs' : 'nav-pills';
        $ul_classes = $options['stacked'] ? array_merge($ul_classes, array('nav-stacked')) : $ul_classes;
        $ul_classes = $options['justified'] ? array_merge($ul_classes, array('nav-justified')) : $ul_classes;

        $classes = $options['classes'] ? $options['classes'] : array();
        $menu_attributes = $menu->getAttributes();
        $menu_classes = isset($menu_attributes['class']) ? (is_array($menu_attributes['class']) ? $menu_attributes['class'] : array($menu_attributes['class'])) : array();
        $classes = array_merge($classes, $menu_classes);

        $params = array(
            'ul_classes' => $ul_classes,
            'classes' => $classes,
        );

        $menu_item = $this->getRenderMenuItem($menu->getRootContainer(), $level);

        return $this->templating->renderResponse(
            $options['template'],
            array('menu_item' => $menu_item, 'params' => $params, 'translation_domain' => $menu->getTranslationDomain())
        );
    }

    /**
     * Renders the menu with a template suitable for mobiles and tablets
     *
     * @param Menu $menu
     * @param arrazy $options
     */
    private function renderCustomMenu(Menu $menu, $options)
    {
        // Get the template to use
        if (isset($options['template'])) {
            $template = $options['template'];

            return $this->templating->renderResponse(
                $template,
                array('menu' => $menu, 'params' => $options)
            );
        }
        else {
            throw new \RuntimeException('Menu template not specified.');
        }
    }

    /**
     * Gets the submenu in the selected level following the active trail
     *
     * @param Module7\MenuBundle\Menu\MenuItem $menu_item
     * @param integer $level
     *
     * @return Module7\MenuBundle\Menu\Menu
     */
    private function getRenderMenuItem(MenuItem $menu_item, $level)
    {
        $render_menu = null;

        if ($level > 1) {
            $active_child = $menu_item->getActiveChild();
            if ($active_child) {
                return $this->getRenderMenuItem($active_child, $level-1);
            }
        }
        else {
            return $menu_item;
        }

        return null;
    }
}