<?php
declare(strict_types=1);

namespace Nip\Container;

use Nip\Container\Bridges\SymfonyContainer;
use Nip\Container\Delegates\ServiceProvidersContainer;
use Nip\Container\Legacy\Container\Traits\DeprecatedMethodsTrait;
use Nip\Container\ReflectionContainer\ReflectionContainer;
use Nip\Container\ServiceProviders\ProviderRepository;
use Nip\Container\ServiceProviders\ServiceProviderAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface as SymfonyContainerInterface;

/**
 * Class Container
 * @package Nip\Container
 */
class Container extends SymfonyContainer implements ContainerInterface
{
    use Traits\BaseMethodsTrait;
    use Traits\ContainerPersistenceTrait;
    use Traits\ContainerArrayAccessTrait;
    use Traits\CanDelegateTrait;
    use ServiceProviderAwareTrait;
    use DeprecatedMethodsTrait;

    public function __construct(?SymfonyContainerInterface $container = null)
    {
        parent::__construct($container);

        $providerContainer = new ServiceProvidersContainer();
        $providerContainer->setContainer($this);
        $providerContainer->setProviderRepository($this->getProviderRepository());
        $this->delegate($providerContainer);

        $this->delegate(new ReflectionContainer());
    }

    public function setProviderRepository(?ProviderRepository $providerRepository): void
    {
        $this->getDelegate(ServiceProvidersContainer::NAME)->setProviderRepository($providerRepository);
    }


}
