<?php

namespace Encore\Console;

use Encore\Console\Application as Console;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $app = $this->app;

        $this->app->singleton('console', function() use ($app) {
            return new Console('EncorePHP', $app::VERSION);
        });
    }
}