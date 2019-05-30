<?php

namespace Nip\Container\Tests;

use Nip\Container\Container;
use Nip\Container\Tests\Fixtures\ModulesService;

/**
 * Class ContainerTest
 * @package Nip\Tests\Container
 */
class ContainerTest extends AbstractTest
{
    // tests

    public function testSetsAndGetServiceDefaultNotShared()
    {
        $container = new Container;

        $container->add('service', '\stdClass');
        static::assertTrue($container->has('service'));

        $service1 = $container->get('service');
        $service2 = $container->get('service');

        static::assertInstanceOf('\stdClass', $service1, '->assert service init');
        static::assertInstanceOf('\stdClass', $service2, '->assert service init');
        static::assertNotSame($service1, $service2, '->assert not shared by default');
    }

    public function testSetsAndGetServiceShared()
    {
        $container = new Container;

        $container->add('service', '\stdClass', true);
        static::assertTrue($container->has('service'));

        $service1 = $container->get('service');
        $service2 = $container->get('service');

        static::assertInstanceOf('\stdClass', $service1, '->assert service init');
        static::assertInstanceOf('\stdClass', $service2, '->assert service init');
        static::assertSame($service1, $service2, '->assert shared');
    }

    /**
     * Asserts that the container sets and gets an instance as shared.
     */
    public function testSetsAndGetInstanceAsShared()
    {
        $container = new Container;
        $class = new \stdClass;
        $container->add('service', $class);
        static::assertTrue($container->has('service'));
        static::assertSame($container->get('service'), $class);
    }

    /**
     * Asserts that the container sets and gets shared overwrite
     */
    public function testAutoInitClasses()
    {
        $container = new Container();

        $service = $container->get(ModulesService::class, [['organizers']]);
        self::assertInstanceOf(ModulesService::class, $service);
        self::assertSame('organizers', $service['organizers']);

        $service2 = $container->get(ModulesService::class);
        self::assertSame($service, $service2);
    }

    /**
     * Asserts that the container sets and gets shared overwrite
     */
    public function testSetAndGetServiceSharedOverwrite()
    {
        $container = new Container();

        $container->add('service', Fixtures\ModulesService::class, true);
        static::assertTrue($container->has('service'));

        $modules1 = $container->get('service');
        static::assertInstanceOf(Fixtures\ModulesService::class, $modules1, '->assert service initial class');

        $container->add('service', '\stdClass', true);
        $modules2 = $container->get('service');
        static::assertInstanceOf('\stdClass', $modules2, '->assert service overwrite');

        $container->add('service', new \stdClass());
        $modules3 = $container->get('service');
        static::assertInstanceOf('\stdClass', $modules3, '->assert service overwrite');
        static::assertNotSame($modules2, $modules3);
    }

    /**
     * Asserts that the container sets and gets shared overwrite
     */
    public function testSetAndGetServiceSharedClosuer()
    {
        $container = new Container();
        $container->share(
            'service',
            function () {
                return new Fixtures\ModulesService();
            }
        );
        static::assertInstanceOf(Fixtures\ModulesService::class, $container->get('service'));
    }
}
