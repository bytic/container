<?php

declare(strict_types=1);

namespace Nip\Container\ReflectionContainer\Argument\Literal;

use League\Container\Argument\LiteralArgument;

class CallableArgument extends LiteralArgument
{
    public function __construct(callable $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_CALLABLE);
    }
}
