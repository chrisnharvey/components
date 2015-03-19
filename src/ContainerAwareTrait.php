<?php

namespace Encore\Container;

use UnexpectedValueException;

trait ContainerAwareTrait
{
    /**
     * An instance of the container
     *
     * @var Container
     */
    protected $container;

    /**
     * Get the container.
     *
     * @return  Container
     * @throws  \UnexpectedValueException May be thrown if the container has not been set.
     */
    public function getContainer()
    {
        if ( ! isset($this->container)) {
            throw new UnexpectedValueException('Container has not been set');
        }

        return $this->container;
    }

    /**
     * Set the container.
     *
     * @param   Container $container The container.
     * @return  void
     */
    public function setContainer(Container $container)
    {
        $this->container = $container;
    }
}
