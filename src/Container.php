<?php

namespace Nip\Container;

use League\Container\Definition\DefinitionAggregateInterface;
use League\Container\Inflector\InflectorAggregateInterface;
use League\Container\ServiceProvider\ServiceProviderAggregateInterface;
use Nip\Container\Bridges\LeagueContainer;
use Nip\Container\Legacy\Container\Traits\DeprecatedMethodsTrait;

/**
 * Class Container
 * @package Nip\Container
 */
class Container extends LeagueContainer implements ContainerInterface
{
    use Traits\ContainerPersistenceTrait;
    use DeprecatedMethodsTrait;

    /**
     * @inheritdoc
     */
    public function __construct(
        DefinitionAggregateInterface $definitions = null,
        ServiceProviderAggregateInterface $providers = null,
        InflectorAggregateInterface $inflectors = null
    ) {
        parent::__construct($definitions, $providers, $inflectors);

        // register the reflection container as a delegate to enable auto wiring
        $this->delegate(
            new \League\Container\ReflectionContainer
        );
    }
}
