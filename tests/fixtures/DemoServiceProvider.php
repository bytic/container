<?php
declare(strict_types=1);

namespace Nip\Container\Tests\Fixtures;

use Nip\Container\ServiceProviders\Providers\AbstractServiceProvider;

/**
 * Class DemoServiceProvider
 * @package Nip\Container\Tests\Fixtures
 */
class DemoServiceProvider extends AbstractServiceProvider
{
    public const DUMMY_CONSTANT = 'dummy';

    /**
     * @inheritDoc
     */
    public function provides(): array
    {
        return [
            self::DUMMY_CONSTANT,
        ];
    }

    public function register()
    {
        $this->container->set(self::DUMMY_CONSTANT, 'value');
    }
}
