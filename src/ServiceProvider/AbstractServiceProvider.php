<?php

namespace Nip\Container\ServiceProvider;

use Nip\Container\ContainerAwareTrait;
use Nip\Container\ServiceProvider\Traits\HasCommands;

/**
 * Class AbstractServiceProvider.
 *
 * @inspiration https://github.com/thephpleague/container/blob/master/src/ServiceProvider/AbstractServiceProvider.php
 */
abstract class AbstractServiceProvider implements ServiceProviderInterface
{
    use ContainerAwareTrait;
    use HasCommands;

    /**
     * @param null|string $service
     *
     * @return bool
     */
    public function isProviding($service)
    {
        return in_array($service, $this->provides());
    }
}
