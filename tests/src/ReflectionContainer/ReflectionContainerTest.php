<?php
declare(strict_types=1);

namespace Nip\Container\Tests\ReflectionContainer;

use Nip\Container\Container;
use Nip\Container\ReflectionContainer\ReflectionContainer;
use Nip\Container\Tests\Fixtures\ModulesService;
use Nip\Container\Tests\Fixtures\ObjectHasConstructor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

/**
 *
 */
class ReflectionContainerTest extends TestCase
{

    public function testThrowsWhenGettingNonExistentClass(): void
    {
        $this->expectException(ServiceNotFoundException::class);
        $container = new ReflectionContainer();
        $container->get('Whoooo');
    }
    public function testGetInstantiatesClassWithConstructorAndUsesContainer(): void
    {
        $classWithConstructor = ObjectHasConstructor::class;
        $dependencyClass      = ModulesService::class;

        $dependency = new $dependencyClass();
        $container  = new ReflectionContainer();

        $container->setContainer($this->getContainerMock([
            $dependencyClass => $dependency,
        ]));

        $item = $container->get($classWithConstructor);

        self::assertInstanceOf($classWithConstructor, $item);
        self::assertSame($dependency, $item->modulesService);
    }
    private function getContainerMock(array $items = []): Container
    {
        $container = $this->getMockBuilder(Container::class)->getMock();

        $container
            ->method('has')
            ->willReturnCallback(function ($alias) use ($items) {
                return array_key_exists($alias, $items);
            })
        ;

        $container
            ->method('get')
            ->willReturnCallback(function ($alias) use ($items) {
                if (array_key_exists($alias, $items)) {
                    return $items[$alias];
                }
            })
        ;

        return $container;
    }
}
