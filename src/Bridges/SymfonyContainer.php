<?php
declare(strict_types=1);

namespace Nip\Container\Bridges;

use Closure;
use Nip\Container\ServiceProviders\ServiceProviderAwareTrait;
use Nip\Container\Utility\BuildSymfonyContainer;
use Nip\Utility\Stringable;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use UnitEnum;

/**
 * Class LeagueContainer
 * @package Nip\Container\Bridges
 */
abstract class SymfonyContainer implements BridgeInterface
{
    use ServiceProviderAwareTrait;

    protected $container;

    /**
     * @param $container
     */
    public function __construct($container = null)
    {
        $this->container = $container ?? BuildSymfonyContainer::create();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->container, $name], $arguments);
    }

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

    /**
     * @inheritDoc
     */
    public function has($id): bool
    {
        if ($this->container->hasParameter($id)) {
            return true;
        }

//        if ($this->getProviderRepository()->provides($id)) {
//            return true;
//        }

        return $this->container->has($id);
    }

    public function add($alias, $concrete = null, $shared = false)
    {
        $this->set($alias, $concrete);
    }

    public function get(string $id, int $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE): ?object
    {
//        if ($this->getProviderRepository()->provides($id)) {
//            $this->getProviderRepository()->register($id);
//        }

        if ($this->container->hasParameter($id)) {
            $param = $this->container->getParameter($id);
            if (is_string($param)) {
                return new Stringable($param);
            }
            return $param;
        }

        if (false === $this->container->has($id) && class_exists($id)) {
            $definition = new Definition($id);
            $definition->setAutowired(true);
            $this->container->setDefinition($id, $definition);
        }

        $return = $this->container->get($id, $invalidBehavior);
        if ($return instanceof Closure) {
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

    public function initialized(string $id): bool
    {
        return $this->container->initialized($id);
    }

    public function getParameter(string $name)
    {
        return $this->container->getParameter($name);
    }

    public function hasParameter(string $name): bool
    {
        return $this->container->hasParameter($name);
    }

    public function setParameter(string $name, UnitEnum|float|array|bool|int|string|null $value)
    {
        $this->container->setParameter($name, $value);
    }

    public function compile()
    {
        $this->registerProviders();
        BuildSymfonyContainer::cache($this->container);
    }

    protected function registerProviders()
    {
        $this->registerConfiguredProviders();
        $providers = $this->getProviderRepository()->getProviders();
        foreach ($providers as $provider) {
            $provider->register();
        }
    }
}
