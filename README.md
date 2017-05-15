MenuBundle
================

MenuBundle is a Symfony bundle that provides an easy way build menus based in Bootstrap nav and nav-bar components.

# Installation

You can install the bundle using composer:

```bash
composer require jagilpe/menu-bundle
```

or add the package to your composer.json file directly.

To enable the bundle, you just have to register the bundle in your AppKernel.php file:

```php
// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Jagilpe\MenuBundle\JagilpeMenuBundle(),
    // ...
);
```

This bundle depends on Bootstrap 3. Please refer to the [Bootstrap 3 documentation](https://getbootstrap.com) 
to integrate it your application.
 
# Documentation

You can access the usage documentation [here](Resources/doc/index.md)

# API Reference

https://api.gilpereda.com/menu-bundle/master/