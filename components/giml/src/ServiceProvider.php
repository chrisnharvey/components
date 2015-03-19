<?php

namespace Encore\Giml;

use Encore\Giml\Support\View as ViewParser;
use Encore\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the GIML reader into the container.
     *
     * @return void
     */
    public function register()
    {
        $this->container['giml.reader'] = new Reader;
    }

    /**
     * Add .gim extension to the view finder
     * 
     * @return void
     */
    public function boot()
    {
        if ($this->container->bound('view.viewfinder')) {
            $this->container['view.viewfinder']->addExtension('gim');
        }
    }
}