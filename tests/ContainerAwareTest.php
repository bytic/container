<?php

namespace Nip\Container\Tests;

use Nip\Container\Container;
use Nip\Container\Tests\Fixtures\ObjectHasContainer;

/**
 * Class ContainerTest
 * @package Nip\Tests\Container
 */
class ContainerAwareTest extends AbstractTest
{
    public function testCheckInitOnlyOnce()
    {
        $object = new ObjectHasContainer();
        $object->getContainer()->set('test', 'value');

        self::assertInstanceOf(Container::class, $object->getContainer());
        self::assertEquals('value', $object->getContainer()->get('test'));
    }
}
