<?php
declare(strict_types=1);

namespace Nip\Container\Tests;

use Mockery;
use Nip\Container\Container;
use PHPUnit\Framework\TestCase;

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
