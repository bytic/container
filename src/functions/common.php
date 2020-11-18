<?php

if (!function_exists('app')) {
    /**
     * Get the available container instance.
     *
     * @param string $make
     * @param array $parameters
     * @return mixed
     */
    function app($make = null, $parameters = [])
    {
        return \Nip\Container\Utility\Container::get($make, $parameters);
    }
}
