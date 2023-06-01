<?php
declare(strict_types=1);

namespace Nip\Container;

use Nip\Container\Bridges\SymfonyContainer;
use Nip\Container\Legacy\Container\Traits\DeprecatedMethodsTrait;

/**
 * Class Container
 * @package Nip\Container
 */
class Container extends SymfonyContainer implements ContainerInterface
{
    use Traits\ContainerPersistenceTrait;
    use DeprecatedMethodsTrait;

}
