<?php
declare(strict_types=1);

namespace Nip\Container\Tests;

use Nip\Container\Container;
use Nip\Container\Tests\Fixtures\ObjectHasContainer;

/**
 * Class ContainerTest
 * @package Nip\Tests\Container
 */
class ContainerAwareTest extends AbstractTestCase
{
    public function testCheckInitOnlyOnce()
    {
        $object = new ObjectHasContainer();
        $object->initContainer();

        $object->getContainer()->set('test', 'myMalue');

        self::assertInstanceOf(Container::class, $object->getContainer());
        self::assertEquals('myMalue', $object->getContainer()->get('test'));
    }
}
