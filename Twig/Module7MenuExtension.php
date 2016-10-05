<?php

namespace Module7\MenuBundle\Twig;

use Module7\ComponentsBundle\Twig\Functions\EntityElementRenderer;
use Module7\MenuBundle\Service\MenuServiceInterface;
use Module7\MenuBundle\Renderer\MenuRenderer;
use Module7\MenuBundle\Provider\MenuProviderInterface;

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

    public function __construct()
    {

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
}