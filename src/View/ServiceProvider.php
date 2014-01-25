<?php

namespace Encore\View;

use Illuminate\Filesystem\Filesystem;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->instance('view', function() {
            $finder = new FileFinder(new Filesystem, $this->app['config']['view.paths']);

            return new Manager($finder);
        });
    }
}