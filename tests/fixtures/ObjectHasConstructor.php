<?php

namespace Nip\Container\Tests\Fixtures;

use Nip\Container\ContainerAwareTrait;

/**
 * Class ObjectHasContainer
 * @package Nip\Container\Tests\Fixtures
 */
class ObjectHasConstructor
{
    public ModulesService $modulesService;

    /**
     * @param ModulesService $modulesService
     */
    public function __construct(ModulesService $modulesService)
    {
        $this->modulesService = $modulesService;
    }
}
