<?php
declare(strict_types=1);

namespace Nip\Container\Tests\ServiceProviders;

use Nip\Container\Container;
use Nip\Container\ServiceProviders\ProviderRepository;
use Nip\Container\Tests\AbstractTestCase;
use Nip\Container\Tests\Fixtures\DemoServiceProvider;

/**
 * Class ProviderRepositoryTest
 * @package Nip\Container\Tests\ServiceProviders
 */
class ProviderRepositoryTest extends AbstractTestCase
{
    public function test_getProvider_not_exists()
    {
        $repository = new ProviderRepository();
        self::assertNull($repository->getProvider('NotFound'));
    }

    public function test_getProvider_with_string()
    {
        $repository = new ProviderRepository();
        $repository->setContainer(new Container());
        $repository->add(DemoServiceProvider::class);
        self::assertInstanceOf(DemoServiceProvider::class, $repository->getProvider(DemoServiceProvider::class));
    }

    public function test_getProvider_with_object()
    {
        $repository = new ProviderRepository();
        $repository->setContainer(new Container());
        $provider = new DemoServiceProvider();
        $repository->add($provider);
        $providerReturned = $repository->getProvider($provider);
        self::assertSame($providerReturned, $provider);
    }
}