<?php

namespace Encore\Development;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container['config']->addLocation($this->container->basePath().'/dev/config');

        foreach ($this->container['config']->get('app.providers') as $provider) {
            $this->container->addProvider($provider);
        }
    }

    public function commands()
    {
        return ['Encore\Development\Command\Debug'];
    }
}
