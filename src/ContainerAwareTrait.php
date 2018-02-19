<?php

namespace Nip\Container;

/**
 * Class ContainerAwareTrait.
 */
trait ContainerAwareTrait
{
    /**
     * @var ContainerInterface|Container|null
     */
    protected $container = null;

    /**
     * Get the container.
     *
     * @return Container
     */
    public function getContainer()
    {
        if ($this->hasContainer()) {
            $this->initContainer();
        }

        return $this->container;
    }

    /**
     * Set a container.
     *
     * @param Container|ContainerInterface $container
     *
     * @return $this
     */
    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;

        return $this;
    }

    public function initContainer()
    {
        $this->container = $this->newContainer();
        Container::setInstance($this->container);
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
