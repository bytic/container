<?php
declare(strict_types=1);

namespace Nip\Container\Tests;

use Bytic\Phpqa\PHPUnit\TestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Nip\Container\Container;

/**
 * Class AbstractTest
 */
abstract class AbstractTestCase extends TestCase
{
    protected $object;

    protected function setUp(): void
    {
        parent::setUp();
        Container::setInstance(new Container());
        \Nip\Container\Utility\Container::container(true);
    }

    /**
     * This method is called after each test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        Mockery::close();
    }
}
