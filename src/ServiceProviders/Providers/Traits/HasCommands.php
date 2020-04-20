<?php

namespace Nip\Container\ServiceProviders\Providers\Traits;

/**
 * Trait HasCommands
 * @package Nip\Container\ServiceProvider\Traits
 */
trait HasCommands
{
    protected $commands = null;

    /**
     * @param array|mixed $commands
     */
    public function commands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();
        $this->commands = array_merge($commands);
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        if ($this->commands === null) {
            $this->initCommands();
        }
        return $this->commands;
    }

    protected function initCommands()
    {
        $this->commands = [];
        if (method_exists($this, 'registerCommands')) {
            $this->registerCommands();
        }
    }
}
