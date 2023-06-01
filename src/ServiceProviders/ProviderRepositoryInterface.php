<?php
declare(strict_types=1);

namespace Nip\Container\ServiceProviders;

use Nip\Container\ContainerAwareInterface;
use Nip\Container\ServiceProviders\Providers\AbstractServiceProvider;

/**
 * Interface ServiceProviderAggregateInterface
 * @package Nip\Container\ServiceProvider
 */
interface ProviderRepositoryInterface extends ContainerAwareInterface
{
    /**
     * Add a service provider to the aggregate.
     *
     * @param  string|AbstractServiceProvider $provider
     * @return $this
     */
    public function add($provider);

    /**
     * Determines whether a service is provided by the aggregate.
     *
     * @param  string $service
     * @return boolean
     */
    public function provides(string $service);

    /**
     * Invokes the register method of a provider that provides a specific service.
     *
     * @param  string $provider
     * @return void
     */
    public function registerProvider($provider);
}
