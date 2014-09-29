<?php

namespace Encore\Development;

use Encore\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the dev config directory and register providers.
     *
     * @return void
     */
    public function register()
    {
        $this->container['config']->addLocation($this->container->basePath().'/dev/config');

        foreach ($this->container['config']->get('app.providers') as $provider) {
            $this->container->addProvider($provider);
        }
    }

    /**
     * Register the debug command.
     *
     * @return void
     */
    public function commands()
    {
        return ['Encore\Development\Command\Debug'];
    }
}
