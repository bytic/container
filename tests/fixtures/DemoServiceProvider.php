<?php

namespace Nip\Container\Tests\Fixtures;

use Nip\Container\ServiceProviders\Providers\AbstractServiceProvider;

/**
 * Class DemoServiceProvider
 * @package Nip\Container\Tests\Fixtures
 */
class DemoServiceProvider extends AbstractServiceProvider
{

    /**
     * @inheritDoc
     */
    public function provides()
    {
        return ['dummy'];
    }

    public function register()
    {
        // TODO: Implement register() method.
    }
}
