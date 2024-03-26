<?php

declare(strict_types=1);

namespace Nip\Container\ReflectionContainer\Argument\Literal;

use League\Container\Argument\LiteralArgument;

class IntegerArgument extends LiteralArgument
{
    public function __construct(int $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_INT);
    }
}
