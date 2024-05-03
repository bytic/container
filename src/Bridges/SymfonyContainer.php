<?php
declare(strict_types=1);

namespace Nip\Container\Bridges;

use Closure;
use Nip\Container\ServiceProviders\ServiceProviderAwareTrait;
use Nip\Container\Utility\BuildSymfonyContainer;
use Nip\Utility\Stringable;
use Ramsey\Collection\GenericArray;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use UnitEnum;

/**
 * Class LeagueContainer
 * @package Nip\Container\Bridges
 */
abstract class SymfonyContainer implements  \Symfony\Component\DependencyInjection\ContainerInterface
{

    protected $symfonyContainer;

    public function __construct()
    {
        $this->symfonyContainer = BuildSymfonyContainer::create();
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->symfonyContainer, $name], $arguments);
    }

    public function setSymfonyContainer(ContainerInterface $container): void
    {
        $this->symfonyContainer = $container;
    }

    /**
     * @param string $alias
     * @param $concrete
     * @return void
     */
    public function share(string $alias, $concrete = null): void
    {
        $this->set($alias, $concrete);
    }

    /**
     * @param $abstract
     * @param $alias
     * @return void
     */
    public function alias($abstract, $alias)
    {
        if ($abstract === null) {
            return;
        }
        if ($this->symfonyContainer->isCompiled()) {
            $abstract = function () use ($abstract) {
                return $this->get($abstract);
            };
            $this->symfonyContainer->set($alias, $abstract);
            return;
        }
//        if (is_string($abstract)) {
//            $abstract = function () use ($abstract) {
//                return $this->get($abstract);
//            };
//        }
        $this->symfonyContainer->setAlias($alias, $abstract);
    }

    public function remove($alias)
    {
        $this->symfonyContainer->removeAlias($alias);
    }

    /**
     * @inheritDoc
     */
    public function has($id): bool
    {
        if ($this->symfonyContainer->hasParameter($id)) {
            return true;
        }

        return $this->symfonyContainer->has($id);
    }

    /**
     * @param $alias
     * @param $concrete
     * @param $shared
     * @return void
     */
    public function add($alias, $concrete = null, $shared = false)
    {
        $this->set($alias, $concrete);
    }

    public function get(string $id, int $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE): ?object
    {
        if ($this->symfonyContainer->hasParameter($id)) {
            $param = $this->symfonyContainer->getParameter($id);
            return $this->wrapResult($param);
        }

        $return = $this->symfonyContainer->get($id, $invalidBehavior);
        if ($return instanceof Closure) {
            $return = $return();
            $this->set($id, $return);
        }
        return $this->wrapResult($return);
    }

    public function set(string $id, mixed $service): void
    {
        if (is_string($service)) {
            if (class_exists($service)) {
                if ($this->symfonyContainer->isCompiled()) {
                    $abstract = function () use ($service) {
                        return $this->get($service);
                    };
                    $this->symfonyContainer->set($id, $abstract);
                    return;
                }
                $definition = new Definition($service);
                $definition->setAutowired(true);
                $this->symfonyContainer->setDefinition($id, $definition);
                return;
            }
        }

        if (!is_object($service)) {
            $service = $this->wrapResult($service);
        }

        $this->symfonyContainer->set($id, $service);
    }

    public function initialized(string $id): bool
    {
        return $this->symfonyContainer->initialized($id);
    }

    /**
     * @inheritDoc
     */
    public function getParameter(string $name): UnitEnum|float|array|bool|int|string|null
    {
        return $this->symfonyContainer->getParameter($name);
    }

    public function hasParameter(string $name): bool
    {
        return $this->symfonyContainer->hasParameter($name);
    }

    public function setParameter(string $name, UnitEnum|float|array|bool|int|string|null $value): void
    {
        $this->symfonyContainer->setParameter($name, $value);
    }

    public function compile()
    {
        $this->registerProviders();
        $this->symfonyContainer->compile();
        BuildSymfonyContainer::cache($this->symfonyContainer);
    }

    protected function registerProviders()
    {
        $this->registerConfiguredProviders();
        $providers = $this->getProviderRepository()->getProviders();
        foreach ($providers as $provider) {
            $provider->register();
        }
    }

    /**
     * @param $result
     * @return Stringable|GenericArray
     */
    protected function wrapResult($result)
    {
        if (is_string($result)) {
            return new Stringable($result);
        }

        if (is_array($result)) {
            return new GenericArray($result);
        }
        return $result;
    }
}
