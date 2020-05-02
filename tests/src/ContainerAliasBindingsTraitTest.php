<?php

namespace Nip\Container\Tests;

use Nip\Container\Container;
use Nip\Container\Tests\Fixtures\ContainerAliasBindingsObject;

/**
 * Class ContainerAliasBindingsTraitTest
 * @package Nip\Container\Tests
 */
class ContainerAliasBindingsTraitTest extends AbstractTest
{
    public function test_set()
    {
        $container = \Mockery::mock(Container::class);
        $container->shouldReceive('get')->andReturn(1);

        $aliasBinding = new ContainerAliasBindingsObject();
        $aliasBinding->setContainer($container);

        self::assertSame(1, $aliasBinding->get('foe'));
    }
}