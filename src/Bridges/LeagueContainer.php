<?php

namespace Nip\Container\Bridges;

use Closure;
use League\Container\Container as Container;
use League\Container\Definition\Definition;
use League\Container\Definition\DefinitionAggregateInterface;
use League\Container\Definition\DefinitionInterface;
use League\Container\Exception\NotFoundException;
use League\Container\Inflector\InflectorAggregateInterface;
use League\Container\ServiceProvider\ServiceProviderAggregateInterface;
use LogicException;
use Nip\Container\Traits\ContainerArrayAccessTrait;

/**
 * Class LeagueContainer
 * @package Nip\Container\Bridges
 */
abstract class LeagueContainer extends Container implements BridgeInterface
{
    protected $reflectionContainer;

    use ContainerArrayAccessTrait;

    /**
     * @inheritdoc
     */
    public function __construct(
        DefinitionAggregateInterface $definitions = null,
        ServiceProviderAggregateInterface $providers = null,
        InflectorAggregateInterface $inflectors = null
    ) {
        parent::__construct($definitions, $providers, $inflectors);

        $this->reflectionContainer = new \League\Container\ReflectionContainer;

        // register the reflection container as a delegate to enable auto wiring
        $this->delegate($this->reflectionContainer);
    }

    /**
     * The registered type aliases.
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * @inheritdoc
     */
    public function set($alias, $concrete = null, $share = false)
    {
        return $this->add($alias, $concrete, $share);
    }

    /**
     * @inheritDoc
     */
    public function add(string $id, $concrete = null, bool $shared = null): DefinitionInterface
    {
        // Overwrite definition if already exists
        if ($this->definitions->has($id)) {
            $concrete = $concrete ?? $id;
            $shared = $shared ?? $this->defaultToShared;

            $definition = $this->definitions->getDefinition($id);
            $definition->setConcrete($concrete);
            $definition->setShared($shared);
            return $definition;
        }
        return parent::add($id, $concrete, $shared);
    }


    /**
     * @inheritdoc
     */
    public function remove($alias)
    {
    }

    /**
     * Determine if a given string is an alias.
     *
     * @param  string $name
     * @return bool
     */
    public function isAlias($name)
    {
        return isset($this->aliases[$name]);
    }

    /**
     * Alias a type to a different name.
     *
     * @param  string $abstract
     * @param  string $alias
     * @return void
     */
    public function alias($abstract, $alias)
    {
        $this->aliases[$alias] = $abstract;
//        $this->abstractAliases[$abstract][] = $alias;

        $this->share($alias, function () use ($abstract) {
            return $this->get($abstract);
        });
    }

    /**
     * Get the alias for an abstract if available.
     *
     * @param  string $abstract
     * @return string
     *
     * @throws \LogicException
     */
    public function getAlias($abstract)
    {
        if (!isset($this->aliases[$abstract])) {
            return $abstract;
        }
        if ($this->aliases[$abstract] === $abstract) {
            throw new LogicException("[{$abstract}] is aliased to itself.");
        }
        return $this->getAlias($this->aliases[$abstract]);
    }

    /**
     * An alias function name for make().
     *
     * @param string|callable $abstract
     * @param array $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    public function makeWith($abstract, array $parameters = [])
    {
        return $this->make($abstract, $parameters);
    }

    /**
     * Resolve the given type from the container.
     *
     * @param string|callable $abstract
     * @param array $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    public function make($abstract, array $parameters = [])
    {
        try {
            $definition = $this->extend($abstract);
            $newDefinition = new Definition($definition->getAlias(), $definition->getConcrete());
            $newDefinition->addArguments($parameters);
            return $newDefinition->resolve();
        } catch (NotFoundException $exception) {
            return $this->build($abstract, $parameters);
        }
    }

    /**
     * @param $concrete
     * @param array $parameters
     * @return mixed
     * @throws \ReflectionException
     */
    protected function build($concrete, array $parameters)
    {
        // If the concrete type is actually a Closure, we will just execute it and
        // hand back the results of the functions, which allows functions to be
        // used as resolvers for more fine-tuned resolution of these objects.
        if ($concrete instanceof Closure) {
            return $concrete($this, $parameters);
        }
        return $this->reflectionContainer->get($concrete, $parameters);
    }
}
