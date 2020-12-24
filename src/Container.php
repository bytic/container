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
}
