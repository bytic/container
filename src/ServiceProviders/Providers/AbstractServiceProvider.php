<?php

namespace Nip\Container\ServiceProviders\Providers;

use Nip\Container\ContainerAwareTrait;
use Nip\Container\ServiceProviders\Providers\Traits\HasCommands;

/**
 * Class AbstractServiceProvider
 * @package Nip\Container
 *
 * @inspiration https://github.com/thephpleague/container/blob/master/src/ServiceProvider/AbstractServiceProvider.php
 */
abstract class AbstractServiceProvider implements ServiceProviderInterface
{
    use ContainerAwareTrait;
    use HasCommands;

    /**
     * @param null|string $service
     * @return bool
     */
    public function isProviding($service)
    {
        return in_array($service, $this->provides());
    }
}
