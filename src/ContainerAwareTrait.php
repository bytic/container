<?php
declare(strict_types=1);

namespace Nip\Container;

use Nip\Container\ServiceProviders\ServiceProviderAwareTrait;
use Nip\Utility\Oop;
use Psr\Container\ContainerInterface;
use Psr\Container\ContainerInterface as PsrContainerInterface;

/**
 * Class ContainerAwareTrait
 * @package Nip\Container
 */
trait ContainerAwareTrait
{
    /**
     * @var \Nip\Container\ContainerInterface
     */
    protected $container;

    /**
     * Get the container.
     *
     * @return ContainerInterface|Container
     */
    public function getContainer(): PsrContainerInterface|Container
    {
        return $this->container;
    }

    /**
     * Set a container.
     *
     * @param ContainerInterface $container
     * @return $this
     */
    public function setContainer(PsrContainerInterface $container)
    {
        $this->container = $container;
        return $this;
    }

    public function initContainer()
    {
        $container = Container::getInstance();
        if ($container instanceof Container) {
            $this->container = $container;
        } else {
            $this->container = $this->newContainer();
            Container::setInstance($this->container);
        }
        if (Oop::classUsesTrait($this, ServiceProviderAwareTrait::class)) {
            $this->container->setProviderRepository($this->getProviderRepository());
        }
    }

    /**
     * @return Container
     */
    public function newContainer()
    {
        return new Container();
    }

    /**
     * @return bool
     */
    public function hasContainer()
    {
        return $this->container instanceof ContainerInterface;
    }
}
