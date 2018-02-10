<?php

namespace Nip\Container\Definition;

use ReflectionClass;

/**
 * Class ClassDefinition.
 */
class ClassDefinition extends AbstractDefinition implements DefinitionInterface
{
    /**
     * @var array
     */
    protected $methods = [];

    /**
     * @param array $args
     * @return mixed|object
     * @throws \ReflectionException
     */
    public function build(array $args = [])
    {
//        $args = (empty($args)) ? $this->arguments : $args;
        $reflection = new ReflectionClass($this->concrete);
        $instance = $reflection->newInstanceArgs();

        return $instance;
    }
}
