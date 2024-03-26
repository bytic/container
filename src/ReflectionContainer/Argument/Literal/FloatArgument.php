<?php

declare(strict_types=1);

namespace Nip\Container\ReflectionContainer\Argument\Literal;

use League\Container\Argument\LiteralArgument;

class FloatArgument extends LiteralArgument
{
    public function __construct(float $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_FLOAT);
    }
}
