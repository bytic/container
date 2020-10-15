<?php

namespace Nip\Container\Tests;

use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Nip\Container\Container;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTest
 */
abstract class AbstractTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    protected $object;

    protected function setUp(): void
    {
        parent::setUp();
        \Nip\Container\Container::setInstance(new Container());
        \Nip\Utility\Container::container(true);
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        \Mockery::close();
    }
}
