<?php

declare(strict_types=1);

namespace Nip\Container\ReflectionContainer\Argument\Literal;

use League\Container\Argument\LiteralArgument;

class ObjectArgument extends LiteralArgument
{
    public function __construct(object $value)
    {
        parent::__construct($value, LiteralArgument::TYPE_OBJECT);
    }
}
