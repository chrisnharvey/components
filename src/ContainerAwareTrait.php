<?php
/**
 * This file is part of the Encore\Container library.
 *
 * (c) Chris Harvey <chris@chrisnharvey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Encore\Container;

/**
 * Container Aware Trait
 *
 * @author  Chris Harvey <chris@chrisnharvey.com>
 */
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
            throw new \UnexpectedValueException('Container has not been set');
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
