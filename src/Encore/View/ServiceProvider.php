<?php

namespace Encore\View;

use Illuminate\Filesystem\Filesystem;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $app = $this->app;

        $this->app->instance('view', function() use ($app) {
            $finder = new FileFinder(new Filesystem, $app['config']['view.paths']);

            return new Manager($finder);
        });
    }
}