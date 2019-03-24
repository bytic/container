<?php

namespace Nip\Container\Legacy\Container\Traits;

/**
 * Trait DeprecatedMethodsTrait
 * @package Nip\Container\Legacy\Container\Traits
 */
trait DeprecatedMethodsTrait
{

    /**
     * Register a shared binding in the container.
     *
     * @param string|array $abstract
     * @param \Closure|string|null $concrete
     *
     * @return void
     * @deprecated Use new Share method instead
     */
    public function singleton($abstract, $concrete = null)
    {
        $this->share($abstract, $concrete);
    }
}

