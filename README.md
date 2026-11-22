# Bytic Container

[![Latest Version on Packagist](https://img.shields.io/packagist/v/bytic/container.svg?style=flat-square)](https://packagist.org/packages/bytic/container)
[![Latest Stable Version](https://poser.pugx.org/bytic/container/v/stable)](https://packagist.org/packages/bytic/container)
[![Latest Unstable Version](https://poser.pugx.org/bytic/container/v/unstable)](https://packagist.org/packages/bytic/container)

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/travis/ByTIC/framework/master.svg?style=flat-square)](https://travis-ci.org/ByTIC/framework)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f59a8256-9bc0-4443-ae3c-488516d6a3e6/mini.png)](https://insight.sensiolabs.com/projects/f59a8256-9bc0-4443-ae3c-488516d6a3e6)
[![Quality Score](https://img.shields.io/scrutinizer/g/bytic/container.svg?style=flat-square)](https://scrutinizer-ci.com/g/bytic/container)
[![StyleCI](https://styleci.io/repos/118474281/shield?branch=master)](https://styleci.io/repos/118474281)
[![Total Downloads](https://img.shields.io/packagist/dt/bytic/container.svg?style=flat-square)](https://packagist.org/packages/bytic/container)

## Symfony integration

The package supports PHP 8.1+ and Symfony DependencyInjection 5.3 through 8.x.
Symfony 8 requires PHP 8.4 or newer. Existing `new Container()`, service
providers, aliases and reflection-based resolution continue to work.

For new services, configure a Symfony `ContainerBuilder` directly and pass it
to the compatibility container:

```php
use Nip\Container\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;

$builder = new ContainerBuilder();
$builder->register(MyService::class)->setAutowired(true)->setPublic(true);
$container = new Container($builder);

// Configure and compile the builder with Symfony's normal APIs when needed.
$builder->compile();
$service = $container->get(MyService::class);
```

`getSymfonyContainer()` exposes the underlying Symfony container;
`setSymfonyContainer()` remains available for existing integrations. A
Symfony container can also be supplied to the constructor. Symfony definitions,
aliases and compiler passes should be configured on a `ContainerBuilder` before
compilation. Symfony's normal visibility and compiled-container restrictions
apply. The legacy providers, reflection fallback and value wrapping belong to
the compatibility container and are not available through the Symfony
container directly.

#### Inspiration 
* https://github.com/container-interop/service-provider
* https://github.com/thecodingmachine/service-provider-bridge-bundle/blob/1.0/src/ServiceProviderCompilationPass.php