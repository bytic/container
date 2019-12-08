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

        //For Old Container there is no need for register
        $providers = $this->getProviderRepository()->getProviders();
        foreach ($providers as $provider) {
            foreach ($provider->provides() as $service) {
                $this->getProviderRepository()->register($service);
            }
        }
    }

    /**
     * @return ProviderRepository
     */
    public function getProviderRepository()
    {
        if ($this->providerRepository === null) {
            $this->providerRepository = new ProviderRepository();
            $this->providerRepository->setContainer($this->getContainer());
            $this->getContainer()->setProviders($this->providerRepository);
        }

        return $this->providerRepository;
    }

    /**
     * @return array
     */
    public function getConfiguredProviders()
    {
        if (function_exists('app') && app()->has('config') && function_exists('config')) {
            $config = config();
            if (is_object($config)) {
                return config()->get('app.providers', $this->getGenericProviders());
            }
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
