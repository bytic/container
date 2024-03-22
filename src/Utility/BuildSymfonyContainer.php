<?php
declare(strict_types=1);

namespace Nip\Container\Utility;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 *
 */
class BuildSymfonyContainer
{

    public static function build()
    {
        $isDebug = false;
        $file = self::cache_file_path();

        if (!$isDebug && file_exists($file)) {
            require_once $file;
            $container = new \ProjectServiceContainer();
            return $container;
        }

        $container = self::create();
        self::cache($container, $isDebug);
        return $container;
    }

    public static function cache($container, $isDebug = false)
    {
        $file = self::cache_file_path();
        $container->compile();

        if (!$isDebug) {
            $dumper = new PhpDumper($container);
            file_put_contents(
                $file,
                $dumper->dump(
                    [
//                            'class' => 'MyCachedContainer',
//                            'base_class' => \Nip\Container\Container::class,
                    ]
                )
            );
        }
    }

    public static function cache_clear()
    {
        unlink(self::cache_file_path());
    }

    public static function create(): ContainerBuilder
    {
        $container = new ContainerBuilder();

        $loader = new PhpFileLoader(
            $container,
            new FileLocator(
                dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config'
            )
        );
        $loader->load('services.php');
        return $container;
    }

    protected static function cache_file_path()
    {
        $dir = function_exists('config_path') ? config_path() : dirname(__DIR__, 2) . '/cache';
        return $dir . '/container.php';
    }
}