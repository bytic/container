<?php

declare(strict_types=1);

namespace Nip\Container\ReflectionContainer\Argument;

interface DefaultValueInterface extends ArgumentInterface
{
    /**
     * @return mixed
     */
    public function getDefaultValue();
}
