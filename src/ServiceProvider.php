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

abstract class ServiceProvider
{
    /**
     * The container instance.
     *
     * @var \Encore\Container\Container
     */
    protected $container;

    /**
     * Create a new service provider instance.
     *
     * @param  \Encore\Container\Container  $container
     * @return void
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {}

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Get the events that trigger this service provider to register.
     *
     * @return array
     */
    public function when()
    {
        return array();
    }
}
