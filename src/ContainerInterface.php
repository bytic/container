<?php
declare(strict_types=1);

namespace Nip\Container;

use ArrayAccess;
use Nip\Container\ServiceProviders\Providers\ServiceProviderInterface;
use Psr\Container\ContainerInterface as PsrInterface;

/**
 * Interface ContainerInterface
 * @package Nip\Container
 */
interface ContainerInterface extends PsrInterface, ArrayAccess
{

    /**
     * Convenience method to add an item to the container as a shared item.
     *
     * @param  string $alias
     * @param  mixed|null $concrete
     */
    public function share(string $alias, $concrete = null);

    /**
     * Convenience method to add an item to the container as a shared item.
     *
     * @param $abstract
     * @param  string $alias
     * @return
     */
    public function alias($abstract, $alias);


    /**
     * @param $alias
     */
    public function remove($alias);

    /**
     * Add a service provider to the container.
     *
     * @param string|ServiceProviderInterface $provider
     * @return void
     */
    public function addServiceProvider($provider);

}
