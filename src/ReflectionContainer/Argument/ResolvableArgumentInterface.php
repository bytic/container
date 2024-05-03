<?php

declare(strict_types=1);

namespace Nip\Container\ReflectionContainer\Argument;

/**
 *
 */
interface ResolvableArgumentInterface extends ArgumentInterface
{
    public function getValue(): string;
}
