<?php

namespace Module7\MenuBundle\Twig;

use Module7\ComponentsBundle\Twig\Functions\EntityElementRenderer;
use Module7\MenuBundle\Service\MenuServiceInterface;
use Module7\MenuBundle\Renderer\MenuRenderer;
use Module7\MenuBundle\Provider\MenuProviderInterface;
use Module7\MenuBundle\Menu\Menu;
use Module7\MenuBundle\Exception\MenuException;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class Module7MenuExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var array
     */
    protected $menuProviders = array();

    /**
     *
     * @var MenuRenderer
     */
    protected $menuRenderer;

    public function __construct(MenuRenderer $menuRenderer)
    {
        $this->menuRenderer = $menuRenderer;
    }

    /**
     * {@inheritDoc}
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'module7_menu_bundle_extension';
    }

    /**
     * {@inheritDoc}
     * @see Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
        $functions = array();

        $functions[] = new \Twig_SimpleFunction(
                        'm7_menu',
                        array($this, 'renderMenu'),
                        array('is_safe' => array('html'),)
                        );

        return $functions;
    }

    /**
     * Adds a MenuProvider
     *
     * @param MenuProviderInterface $menuProvider
     */
    public function addMenuProvider(MenuProviderInterface $menuProvider)
    {
        $this->menuProviders[] = $menuProvider;
    }

    /**
     * Renders a view of a determined menu
     *
     * @param string $menuName
     * @param string $menuView
     * @param array $parameters
     *
     * @return string
     */
    public function renderMenu($menuName, $menuView = MenuRenderer::MENU_FULL, array $options = array())
    {
        $menu = $this->getMenu($menuName);
        return $this->menuRenderer->renderMenu($menu, $menuView, $options);
    }

    /**
     * Looks up for the menu in the different registrered menu providers
     *
     * @param string $menuName
     *
     * @return Menu
     */
    private function getMenu($menuName)
    {
        $menu = null;
        foreach ($this->menuProviders as $menuProvider) {
            $menu = $menuProvider->getMenu($menuName);

            if ($menu) {
                break;
            }
        }

        if (!$menu) {
            throw new MenuException("Menu $menuName does not exists.");
        }

        return $menu;
    }
}