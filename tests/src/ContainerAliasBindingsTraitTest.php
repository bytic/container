<?php
declare(strict_types=1);

namespace Nip\Container\Tests;

use Nip\Container\Container;
use Nip\Container\Tests\Fixtures\ContainerAliasBindingsObject;

/**
 * Class ContainerAliasBindingsTraitTest
 * @package Nip\Container\Tests
 */
class ContainerAliasBindingsTraitTest extends AbstractTestCase
{
    public function test_set()
    {
        $object  = new \stdClass();
        $container = \Mockery::mock(Container::class);
        $container->shouldReceive('get')->andReturn($object);

        $aliasBinding = new ContainerAliasBindingsObject();
        $aliasBinding->setContainer($container);

        self::assertSame($object, $aliasBinding->get('foe'));
    }
}