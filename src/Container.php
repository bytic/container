<?php

namespace Nip\Container;

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
