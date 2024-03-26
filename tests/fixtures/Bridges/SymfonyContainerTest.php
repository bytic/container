<?php

namespace Nip\Container\Tests\Fixtures\Bridges;

use Nip\Container\Container;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class SymfonyContainerTest extends TestCase
{

    public function testAlias()
    {
        $container = new Container();

        $value = new \stdClass();

        $container->set('id',$value);
        $container->alias('id', LoggerInterface::class);

        self::assertSame($value, $container->get(LoggerInterface::class));
        self::assertSame($value, $container->get('id'));
    }
}
