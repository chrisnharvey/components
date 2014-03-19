<?php
/**
 * This file is part of the Encore\Container library.
 *
 * (c) Don Gilbert <don@dongilbert.net>
 * (c) Chris Harvey <chris@chrisnharvey.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Encore\Container;

/**
 * Container Aware interface
 *
 * @author  Don Gilbert <don@dongilbert.net>
 * @author  Chris Harvey <chris@chrisnharvey.com>
 */
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
