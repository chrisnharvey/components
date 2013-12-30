<?php

namespace Encore\Foundation\Provider;

class Filesystem extends \Encore\Foundation\ServiceProvider
{
    public function register()
    {
        $this->app->bind('filesystem', function() {
            return new \Illuminate\Filesystem\Filesystem;
        });
    }
}