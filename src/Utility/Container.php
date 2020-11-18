<?php

namespace Nip\Container\Utility;

use Exception;
use Nip\Container\Container as NipContainer;
use Psr\Container\ContainerInterface;

/**
 * Class Container
 * @package Nip\Utility
 */
class Container
{
    /**
     * @return false|ContainerInterface|NipContainer
     * @noinspection PhpDocMissingThrowsInspection
     */
    public static function container($reset = false)
    {
        static $instance;
        if ($reset || !($instance instanceof ContainerInterface)) {
            /** @noinspection PhpUnhandledExceptionInspection */
            $instance = static::detect();
        }
        return $instance;
    }

    /**
     * @return ContainerInterface
     * @throws Exception
     */
    public static function detect()
    {
        if (class_exists(NipContainer::class)) {
            return NipContainer::getInstance();
        }
        throw new Exception("No valid container found");
    }

    /**
     * @param null $make
     * @return mixed
     */
    public static function get($make = null)
    {
        if (is_null($make)) {
            return static::container();
        }

        return static::container()->get($make);
    }
}
