<?php

namespace Encore\Foundation\Provider;

class Filesystem extends \Encore\Foundation\ServiceProvider
{
    public function register()
    {
        $this->app['files'] = $this->app->share(function() {
            return new Filesystem;
        });
    }
}