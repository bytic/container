<?php

declare(strict_types=1);

namespace Nip\Container\ReflectionContainer\Argument\Literal;

use League\Container\Argument\LiteralArgument;

class ArrayArgument extends LiteralArgument
{
    public function __construct(array $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_ARRAY);
    }
}
