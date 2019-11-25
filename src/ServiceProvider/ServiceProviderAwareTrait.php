<?php

namespace Nip\Container\ServiceProvider;

/**
 * Class ServiceProviderAwareTrait
 * @package Nip\Container\ServiceProviders
 */
trait ServiceProviderAwareTrait
{
    /**
     * All of the registered service providers.
     *
     * @var ProviderRepository
     */
    protected $providerRepository = null;

    public function registerConfiguredProviders()
    {
        $providers = $this->getConfiguredProviders();
        foreach ($providers as $provider) {
            $this->getProviderRepository()->add($provider);
        }

        $this->getProviderRepository()->register();
    }

    /**
     * @return ProviderRepository
     */
    public function getProviderRepository()
    {
        if ($this->providerRepository === null) {
            $this->providerRepository = new ProviderRepository();
            $this->providerRepository->setContainer($this->getContainer());
        }

        return $this->providerRepository;
    }

    /**
     * @return array
     */
    public function getConfiguredProviders()
    {
        if (function_exists('config')) {
            return config()->get('app.providers', $this->getGenericProviders());
        }
        return $this->getGenericProviders();
    }

    /**
     * @return array
     */
    public function getGenericProviders()
    {
        return [];
    }

    public function bootProviders()
    {
        $this->getProviderRepository()->boot();
    }
}
