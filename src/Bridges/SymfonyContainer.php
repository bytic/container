<?php
declare(strict_types=1);

namespace Nip\Container\Bridges;

use Nip\Container\ServiceProviders\ServiceProviderAwareTrait;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * Class LeagueContainer
 * @package Nip\Container\Bridges
 */
abstract class SymfonyContainer implements BridgeInterface
{
    protected $container;

    /**
     * @param $container
     */
    public function __construct()
    {
        $this->container = new ContainerBuilder();
        $loader = new PhpFileLoader(
            $this->container,
            new FileLocator(
                dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config'
            )
        );
        $loader->load('services.php');
//        $this->container->compile();
//        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__));
//        $this->container->autowire();
    }

    use ServiceProviderAwareTrait;

    public function share(string $alias, $concrete = null)
    {
        $this->set($alias, $concrete);
    }

    public function alias($abstract, $alias)
    {
        if ($abstract === null) {
            return;
        }
//        if (is_string($abstract)) {
//            $abstract = function () use ($abstract) {
//                return $this->get($abstract);
//            };
//        }
        $this->container->setAlias($alias, $abstract);
    }

    public function remove($alias)
    {
        $this->container->removeAlias($alias);
        // TODO: Implement remove() method.
    }

    public function addServiceProvider($provider)
    {
        $this->getProviderRepository()->add($provider);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        // TODO: Implement offsetSet() method.
    }

    public function offsetUnset(mixed $offset): void
    {
        // TODO: Implement offsetUnset() method.
    }

    public function has($id): bool
    {
        if ($this->container->hasParameter($id)) {
            return true;
        }

        if ($this->getProviderRepository()->provides($id)) {
            return true;
        }

        return $this->container->has($id);
    }

    public function add($alias, $concrete = null, $shared = false)
    {
        $this->set($alias, $concrete);
    }

    public function get(string $id, int $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE): mixed
    {
        if ($this->getProviderRepository()->provides($id)) {
            $this->getProviderRepository()->register($id);
        }

        if ($this->container->hasParameter($id)) {
            return $this->container->getParameter($id);
        }

        if (false === $this->container->has($id) && class_exists($id)) {
            $definition = new Definition($id);
            $definition->setAutowired(true);
            $this->container->setDefinition($id, $definition);
        }

        $return = $this->container->get($id, $invalidBehavior);
        if ($return instanceof \Closure) {
            $return = $return();
            $this->set($id, $return);
        }
        return $return;
    }

    public function set(string $id, mixed $service)
    {
        if (is_string($service)) {
            if (class_exists($service)) {
                $definition = new Definition($service);
                $definition->setAutowired(true);
                $this->container->setDefinition($id, $definition);
                return;
            }
            $this->container->setParameter($id, $service);
            return;
        }
        if (!is_object($service)) {
            $this->container->setParameter($id, $service);
            return;
        }
        $this->container->set($id, $service);
    }
}
