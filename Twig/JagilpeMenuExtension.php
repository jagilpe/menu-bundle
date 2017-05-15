<?php

namespace Jagilpe\MenuBundle\Twig;

use Jagilpe\MenuBundle\Factory\MenuBuilderFactory;
use Jagilpe\MenuBundle\Provider\MenuProviderFactoryAwareInterface;
use Jagilpe\MenuBundle\Renderer\MenuRenderer;
use Jagilpe\MenuBundle\Provider\MenuProviderInterface;
use Jagilpe\MenuBundle\Menu\Menu;
use Jagilpe\MenuBundle\Exception\MenuException;

/**
 *
 * @author Javier Gil Pereda <javier.gil@module-7.com>
 */
class JagilpeMenuExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    /**
     * @var array
     */
    protected $menuProviders = array();

    /**
     * @var MenuBuilderFactory
     */
    protected $menuFactory;

    /**
     *
     * @var MenuRenderer
     */
    protected $menuRenderer;

    public function __construct(MenuRenderer $menuRenderer, MenuBuilderFactory $menuFactory)
    {
        $this->menuRenderer = $menuRenderer;
        $this->menuFactory = $menuFactory;
    }

    /**
     * {@inheritDoc}
     * @see Twig_ExtensionInterface::getName()
     */
    public function getName()
    {
        return 'jagilpe_menu_bundle_extension';
    }

    /**
     * {@inheritDoc}
     * @see Twig_Extension::getFunctions()
     */
    public function getFunctions()
    {
        $functions = array();

        $functions[] = new \Twig_SimpleFunction(
                        'jgp_menu',
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
        // If the menu provider is an instance of AbstractMenuProvider inject the Menu Builder Factory
        if ($menuProvider instanceof MenuProviderFactoryAwareInterface) {
            $menuProvider->setMenuFactory($this->menuFactory);
        }
        $this->menuProviders[] = $menuProvider;
    }

    /**
     * Renders a view of a determined menu
     *
     * @param string $menuName
     * @param string $menuView
     * @param array $options
     *
     * @return string
     */
    public function renderMenu($menuName, $menuView = MenuRenderer::MENU_FULL, array $options = array())
    {
        $menu = $this->getMenu($menuName);
        return $this->menuRenderer->renderMenu($menu, $menuView, $options);
    }

    /**
     * Looks up for the menu in the different registered menu providers
     *
     * @param string $menuName
     * @return Menu
     * @throws MenuException
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