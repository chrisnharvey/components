<?php

namespace Encore\Foundation\Provider;

class Filesystem extends \Encore\Foundation\ServiceProvider
{
    public function register()
    {
        $this->app['filesystem'] = $this->app->share(function() {
            return new Filesystem;
        });
    }
}