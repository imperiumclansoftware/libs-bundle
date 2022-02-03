# ICS - LibsBundle

Bundle for append libraries and theme for bootstrap

Included libs :
- [Jquery](https://jquery.com/) `3.6.0`
- [Bootstrat](https://getbootstrap.com/) `5.0.2`
- [Bootswatch themes](https://bootswatch.com/) `5.0.2`
- [Font Awesome Free Icons](https://fontawesome.com/) `5.15.4`

## Installation

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

### Applications that use Symfony Flex

Open a command console, enter your project directory and execute:

```console
composer require ics/libs-bundle
```

### Applications that don't use Symfony Flex

#### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require ics/libs-bundle
```

#### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    ICS\LibsBundle\LibsBundle::class => ['all' => true],
];
```

#### Step 3: Routing

Libs needs route for save user theme choice `config/routes.yaml`

```yaml
# config/routes.yaml

libs_bundle:
  resource: "@LibsBundle/config/routes.yaml"
  prefix: /libs
```

> Theme choice was save in `user.profile.parameters` (array)
> in compatibility with [ics/ssi-bundle](https://github.com/imperiumclansoftware/ssi-bundle)

#### Step 4: Add libs in templates

```twig
{# templates/base.html.twig #}

{{ renderLibs() }}

```

## Configuration

```yaml
# config/packages/libs.yaml

libs:
  # Use CDN if false libs use local files (default: true)
  cdn: true
  # Active bootstrap (default: true)
  bootstrap: true
  # Active jQuery (default: true)
  jquery: true
  # Active Font Awesome Free Icons (default: true)
  fontawesome: true
  # List of Bootswatch enabled themes (default all themes are activated)
  bootstrapthemes: ['cerulean','cosmo','cyborg','darkly','flatly','journal','litera','lumen','lux','materia','minty','morph','pulse','quartz','sandstone','simplex','sketchy','slate','solar','spacelab','superhero','united','vapor','yeti','zephyr']
  # Default should be present in bootstrapthemes list  (default: null)
  bootstrapDefaultTheme: ~

```