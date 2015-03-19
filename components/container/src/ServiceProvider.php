<?php

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
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Get the events that trigger this service provider to register.
     *
     * @return array
     */
    public function when()
    {
        return [];
    }
}
