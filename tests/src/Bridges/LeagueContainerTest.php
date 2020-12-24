<?php

namespace Nip\Container\Tests\Bridges;

use Nip\Container\Container;
use Nip\Container\Tests\Fixtures\ModulesService;

/**
 * Class LeagueContainerTest
 * @package Nip\Container\Tests\Bridges
 */
class LeagueContainerTest extends \Nip\Container\Tests\AbstractTest
{
    public function test_make()
    {
        $container = new Container();

        $modules = $container->make(ModulesService::class);
        self::assertInstanceOf(ModulesService::class, $modules);

        $modules = $container->make(ModulesService::class, ['newModules' => ['widgets']]);
        self::assertInstanceOf(ModulesService::class, $modules);
        self::assertCount(3, $modules);
        self::assertTrue($modules->hasModule('widgets'));

        $container->add('modules', ModulesService::class);
        $modules = $container->make('modules', ['newModules' => ['widgets']]);
        self::assertInstanceOf(ModulesService::class, $modules);
        self::assertCount(3, $modules);
        self::assertTrue($modules->hasModule('widgets'));

        $modules = $container->make('modules', ['newModules' => ['api']]);
        self::assertCount(3, $modules);
        self::assertTrue($modules->hasModule('api'));
    }
}