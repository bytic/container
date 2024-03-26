<?php
declare(strict_types=1);

namespace Nip\Container\Delegates;

use Nip\Container\ContainerAwareTrait;
use Nip\Container\ServiceProviders\ServiceProviderAwareTrait;
use Nip\Container\Traits\ContainerArrayAccessTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 */
class ServiceProvidersContainer implements ContainerDelegateInterface
{

    public const NAME = 'service-providers';

    use ServiceProviderAwareTrait;
    use ContainerArrayAccessTrait;
    use ContainerAwareTrait;

    public function get(string $id, int $invalidBehavior = ContainerInterface::EXCEPTION_ON_INVALID_REFERENCE): ?object
    {
        $this->getProviderRepository()->register($id);
        return $this->getContainer()->get($id);
    }

    public function has(string $id): bool
    {
        return $this->getProviderRepository()->provides($id);
    }
}