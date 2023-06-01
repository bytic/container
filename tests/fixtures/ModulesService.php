<?php
declare(strict_types=1);

namespace Nip\Container\Tests\Fixtures;

use ArrayAccess;

/**
 * Class Modules.
 */
class ModulesService implements ArrayAccess, \Countable
{
    protected $modules = [];

    /**
     * Modules constructor.
     */
    public function __construct($newModules = [])
    {
        $this->init();
        foreach ($newModules as $module) {
            $this->addModule($module);
        }
    }

    public function init()
    {
        $this->addModule('admin');
        $this->addModule('default');
    }

    /**
     * @param $name
     */
    public function addModule($name)
    {
        if (!$this->offsetExists($name)) {
            $this->modules[$name] = $name;
        }
    }

    /**
     * Determine if a given offset exists.
     *
     * @param string $key
     *
     * @return bool
     */
    public function offsetExists(mixed $key): bool
    {
        return array_key_exists($key, $this->modules);
    }

    /**
     * @param $name
     *
     * @return bool
     */
    public function hasModule($name)
    {
        return $this->offsetExists($name);
    }

    /**
     * @return array
     */
    public function getNames()
    {
        return $this->modules;
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getViewPath($name)
    {
        return $this->getModuleDirectory($name) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
    }

    /**
     * @param $name
     *
     * @return string
     */
    public function getModuleDirectory($name)
    {
        return $this->getModulesBaseDirectory() . $name;
    }

    /**
     * @return string
     */
    public function getModulesBaseDirectory()
    {
        return defined('MODULES_PATH') ? MODULES_PATH : '';
    }

    /**
     * Get the value at a given offset.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function offsetGet(mixed $key): mixed
    {
        return $this->modules[$key];
    }

    /**
     * Set the value at a given offset.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet(mixed $key, mixed $value): void
    {
        $this->modules[$key] = $value;
    }

    /**
     * Unset the value at a given offset.
     *
     * @param string $key
     *
     * @return void
     */
    public function offsetUnset(mixed $key): void
    {
        unset($this->modules[$key]);
    }

    public function count(): int
    {
        return count($this->modules);
    }
}
