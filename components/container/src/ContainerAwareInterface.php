<?php

namespace Encore\Container;

interface ContainerAwareInterface
{
    /**
     * Get the container.
     *
     * @return  Container
     * @throws  \UnexpectedValueException May be thrown if the container has not been set.
     */
    public function getContainer();

    /**
     * Set the container.
     *
     * @param   Container  $container  The container.
     * @return  void
     */
    public function setContainer(Container $container);
}
