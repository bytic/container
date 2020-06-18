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
        return \Nip\Utility\Container::get($make, $parameters);
    }
}
