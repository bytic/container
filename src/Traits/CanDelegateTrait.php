<?php
declare(strict_types=1);

namespace Nip\Container\Traits;

use Nip\Container\ContainerAwareInterface;
use Psr\Container\ContainerInterface;

/**
 *
 */
trait CanDelegateTrait
{

    /**
     * @var ContainerInterface[]
     */
    protected array $delegates = [];

    public function delegate(ContainerInterface $container): self
    {
        $this->delegates[$container::NAME] = $container;

        if ($container instanceof ContainerAwareInterface) {
            $container->setContainer($this);
        }

        return $this;
    }

    public function getDelegates(): array
    {
        return $this->delegates;
    }

    public function getDelegate(string $name): ?ContainerInterface
    {
        return $this->delegates[$name] ?? null;
    }
}