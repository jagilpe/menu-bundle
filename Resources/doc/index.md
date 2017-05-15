Jagilpe Menu Bundle Usage Documentation
=======================================

The main goal of the MenuBundle is to assist in the creation of dynamic menus for a Web Application using the Nav and 
NavBar components of Bootstrap 3

# Basic Usage

## Menu Provider

The first step to create a menu provider, that will be responsible to create the menu or menus that will be used in the 
application. The menu provider has to implement the [MenuProviderInterface](https://api.gilpereda.com/menu-bundle/master/Jagilpe/MenuBundle/Provider/MenuProviderInterface.html)
and must be registered as a service using the tag `jgp_menu.service_provider`

Create your menu provider:

```php
<?php
// src/AppBundle/Service/MyMenyProvider.php

namespace AppBundle\Service;

use Jagilpe\MenuBundle\Provider\MenuProviderInterface;

/**
 * Service that provides the menus of the app
 *
 * @author Javier Gil Pereda <javier@gilpereda.com>
 */
class MyMenuProvider implements MenuProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function getMenu($menuName)
    {
        // Here comes the logic to build your menu/s
    }
}
```

The getMenu method must return an instance of the [Jagilpe\MenuBundle\Menu\Menu](https://api.gilpereda.com/menu-bundle/master/Jagilpe/MenuBundle/Menu/Menu.html)
class with the desired menu tree. To make things easier you can extend the class
[Jagilpe\MenuBundle\Provider\AbstractMenuProvider](https://api.gilpereda.com/menu-bundle/master/Jagilpe/MenuBundle/Provider/AbstractMenuProvider.html).
This class has an instance of [Jagilpe\MenuBundle\Menu\MenuBuilder](https://api.gilpereda.com/menu-bundle/master/Jagilpe/MenuBundle/Menu/MenuBuilder.html)
that can be used to build the menu.
 
```php
<?php
// src/AppBundle/Service/MyMenyProvider.php

namespace AppBundle\Service;

use Jagilpe\MenuBundle\Provider\AbstractMenuProvider;

/**
 * Service that provides the menus of the app
 *
 * @author Javier Gil Pereda <javier@gilpereda.com>
 */
class MyMenuProvider extends AbstractMenuProvider
{
    /**
     * {@inheritdoc}
     */
    public function getMenu($menuName)
    {
        // Here comes the logic to build your menu/s
    }
}
```

Through the rest of the documentation we will be using this approach to build the menus.

Register the menu provider

```yaml
# src/AppBundle/Resources/config/services.yml
services:
    app.my_menu_provider:
        class: AppBundle\Service\MyMenuProvider
        tags:
            - { name: jgp_menu.service_provider }
```

You can have as many menu provider as you want in your application. All of them will be asked to return the requested 
menu until one of them returns it. If two providers implements the same menu (menus with the same menu) only the first
returned will be ever used.

## Create a menu

Your implementation of MenuProviderInterface::getMenu should return the requested menu object, or null/false if this menu
provider is not responsible for building the menu. The logic to build the menu can be as simple or as complex as the 
app requires, and you can access any other service to build it using the standard dependency injection of Symfony.

### Simple Menu

```php
<?php
// src/AppBundle/Service/MyMenyProvider.php

namespace AppBundle\Service;

use Jagilpe\MenuBundle\Provider\AbstractMenuProvider;

/**
 * Service that provides the menus of the app
 *
 * @author Javier Gil Pereda <javier@gilpereda.com>
 */
class MyMenuProvider extends AbstractMenuProvider
{
    const MY_APP_MENU = 'my_app_menu';
    
    /**
     * {@inheritdoc}
     */
    public function getMenu($menuName)
    {
        if (self::MY_APP_MENU !== $menuName) {
            return false;
        }
        
        $menuBuilder = $this->menuFactory->createMenuBuilder();
        $menuBuilder->newMenuItem(array(
            'name' => 'Home',
            'route' => 'app_homepage'
        ));
        $menuBuilder->newMenuItem(array(
            'name' => 'Register',
            'route' => 'app_register'
        ));
        
        return $menuBuilder->getMenu();
    }
}
```

### Render the menu in the page

To render the menu in the page you can use the `jgp_render_menu` twig function in your base template.

```twig
{{ jgp_menu('my_app_menu', 'full') }}
```
