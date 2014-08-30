<?php

namespace Encore\GIML;

use Encore\GIML\Support\View as ViewParser;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function register()
    {
        $this->container['giml.reader'] = new Reader;
    }

    public function boot()
    {
        if ($this->container->bound('view.viewfinder')) {
            $this->container['view.viewfinder']->addExtension('gim');
        }
    }
}