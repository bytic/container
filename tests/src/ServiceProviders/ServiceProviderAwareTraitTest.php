<?php
declare(strict_types=1);

namespace Nip\Container\Tests\ServiceProviders;

use Mockery\Mock;
use Nip\Config\Config;
use Nip\Container\Container;
use Nip\Container\Tests\AbstractTestCase;
use Nip\Container\Tests\Fixtures\ServiceProviderAwareObject;

/**
 * Class ServiceProviderAwareTraitTest
 * @package Nip\Container\Tests\ServiceProvider
 */
class ServiceProviderAwareTraitTest extends AbstractTestCase
{
    public function test_getConfiguredProviders_noConfig()
    {
        $object = $this->generateMockedObject();
        $object->shouldReceive('getGenericProviders')->once()->andReturn([]);

        $configured = $object->getConfiguredProviders();
        self::assertIsArray($configured);
    }

    public function test_getConfiguredProviders_fromConfig()
    {
        $container = new Container();
        $config = new Config(['app' => ['providers' => ['test' => 'name']]]);
        $container->set('config', $config);
        Container::setInstance($container);
        \Nip\Container\Utility\Container::container(true);

        $object = $this->generateMockedObject();
        $object->shouldReceive('getGenericProviders')->once()->andReturn([]);

        $configured = $object->getConfiguredProviders();
        self::assertIsArray($configured);
        self::assertArrayHasKey('test', $configured);
    }

    /**
     * @return Mock|ServiceProviderAwareObject
     */
    protected function generateMockedObject()
    {
        $object = \Mockery::mock(ServiceProviderAwareObject::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();
        return $object;
    }
}
