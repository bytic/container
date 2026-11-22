<?php
declare(strict_types=1);

namespace Nip\Container\Tests;

use Nip\Container\Container;
use Nip\Container\Tests\Fixtures\DemoServiceProvider;
use Nip\Container\Tests\Fixtures\ModulesService;
use Nip\Container\Utility\BuildSymfonyContainer;
use Symfony\Component\DependencyInjection\Container as NativeContainer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ContainerTest
 * @package Nip\Tests\Container
 */
class ContainerTest extends AbstractTestCase
{
    public function testSymfonyBuilderCanBeConfiguredAndCompiledDirectly(): void
    {
        $builder = new ContainerBuilder();
        $container = new Container($builder);
        self::assertSame($builder, $container->getSymfonyContainer());

        $builder->register(ModulesService::class, ModulesService::class)->setPublic(true);
        $builder->register(Fixtures\ObjectHasConstructor::class, Fixtures\ObjectHasConstructor::class)
            ->setArgument('$modulesService', new Reference(ModulesService::class))
            ->setPublic(true);
        $builder->setAlias('modules', ModulesService::class)->setPublic(true);
        $builder->setParameter('example', 'value');
        $builder->compile();

        self::assertSame($builder->get(ModulesService::class), $container->get('modules'));
        self::assertSame($container->get('modules'), $container->get(Fixtures\ObjectHasConstructor::class)->modulesService);
        self::assertSame('value', $container->getParameter('example'));
        $container->addServiceProvider(DemoServiceProvider::class);
        self::assertEquals('value', $container->get(DemoServiceProvider::DUMMY_CONSTANT));
    }

    public function testNativeContainerAndLegacyAliasesCanBeUsedTogether(): void
    {
        $native = new NativeContainer();
        $container = new Container($native);
        $native->set('native', $service = new \stdClass());

        $container->alias('native', 'legacy-alias');
        $container->set('class-service', ModulesService::class);

        self::assertSame($service, $container->get('legacy-alias'));
        self::assertInstanceOf(ModulesService::class, $container->get('class-service'));
        self::assertSame($native, $container->getSymfonyContainer());
        $container->remove('legacy-alias');
        self::assertFalse($container->has('legacy-alias'));
        self::assertSame($service, $container->get('native'));
    }

    public function testSymfonyContainerCanStillBeReplaced(): void
    {
        $container = new Container();
        $native = new NativeContainer();
        $native->set('native', $service = new \stdClass());
        $container->setSymfonyContainer($native);

        self::assertSame($native, $container->getSymfonyContainer());
        self::assertSame($service, $container->get('native'));
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
    public function testSetAndGetServiceSharedOverwrite()
    {
        $container = new Container();

        $container->add('service', Fixtures\ModulesService::class, true);
        static::assertTrue($container->has('service'));

        $container->add('service', \stdClass::class, true);
        $modules2 = $container->get('service');
        static::assertInstanceOf(\stdClass::class, $modules2, '->assert service overwrite');

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

    public function test_get_from_service_provider()
    {
        $container = new Container();
        $container->addServiceProvider(DemoServiceProvider::class);

        self::assertTrue($container->has(DemoServiceProvider::DUMMY_CONSTANT));
        self::assertEquals('value', $container->get(DemoServiceProvider::DUMMY_CONSTANT));
    }
}
