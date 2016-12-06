<?php

namespace Module7\MenuBundle\Renderer;

use Module7\MenuBundle\Menu\Menu;
use Module7\MenuBundle\Menu\MenuItem;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This class is used to get a rendered menu using different templates and options
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class MenuRenderer implements ContainerAwareInterface
{
    const MENU_FULL = 'full';
    const MENU_SUBMENU = 'submenu';
    const MENU_SIDEBAR = 'sidebar';
    const MENU_CUSTOM = 'custom';

    private $container;

    /**
     * {@inheritDoc}
     * @see \Symfony\Component\DependencyInjection\ContainerAwareInterface::setContainer()
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function renderMenu(Menu $menu = null, $view = self::MENU_FULL, $options = array())
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
     * @param Menu $menu
     * @param array $options
     *
     * @return string
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

        return $this->container->get('templating')->render(
            $options['template'],
            array('menu' => $menu, 'params' => $params)
        );
    }

    /**
     * Returns a renderd block for the first level elements of the menu
     *
     * @param Menu $menu
     * @param array $options
     *
     * @return string
     */
    private function renderFirstLevelMenu(Menu $menu, $options = array())
    {
        return $this->nLevelMenu($menu, 1, $options);
    }

    /**
     * Returns a rendered block corresponding to the n-level of the menu
     *
     * @param Menu $menu
     * @param integer $level
     * @param array $options
     *
     * @return string
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

        $ulClasses = array('nav');
        $ulClasses[] = $options['type'] == 'tabs' ? 'nav-tabs' : 'nav-pills';
        $ulClasses = $options['stacked'] ? array_merge($ulClasses, array('nav-stacked')) : $ulClasses;
        $ulClasses = $options['justified'] ? array_merge($ulClasses, array('nav-justified')) : $ulClasses;

        $classes = $options['classes'] ? $options['classes'] : array();
        $menuAttributes = $menu->getAttributes();
        $menuClasses = isset($menuAttributes['class']) ? (is_array($menuAttributes['class']) ? $menuAttributes['class'] : array($menuAttributes['class'])) : array();
        $classes = array_merge($classes, $menuClasses);

        $params = array(
            'ul_classes' => $ulClasses,
            'classes' => $classes,
        );

        $menuItem = $this->getRenderMenuItem($menu->getRootContainer(), $level);

        return $this->container->get('templating')->render(
            $options['template'],
            array('menu_item' => $menuItem, 'params' => $params, 'translation_domain' => $menu->getTranslationDomain())
        );
    }

    /**
     * Renders the menu with a template suitable for mobiles and tablets
     *
     * @param Menu $menu
     * @param array $options
     */
    private function renderCustomMenu(Menu $menu, array $options = array())
    {
        // Get the template to use
        if (isset($options['template'])) {
            $template = $options['template'];

            return $this->container->get('templating')->render(
                $template,
                array('menu' => $menu, 'params' => $options)
            );
        } else {
            throw new \RuntimeException('Menu template not specified.');
        }
    }

    /**
     * Gets the submenu in the selected level following the active trail
     *
     * @param MenuItem $menuItem
     * @param integer $level
     *
     * @return MenuItem
     */
    private function getRenderMenuItem(MenuItem $menuItem, $level)
    {
        $renderMenu = null;

        if ($level > 1) {
            $activeChild = $menuItem->getActiveChild();
            if ($activeChild) {
                return $this->getRenderMenuItem($activeChild, $level-1);
            }
        } else {
            return $menuItem;
        }

        return null;
    }
}