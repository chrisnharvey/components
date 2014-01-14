<?php

namespace Encore\Console;

use Encore\Console\Application as Console;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->singleton('console', function() {
            return new Console('EncorePHP', $this->app::VERSION);
        });
    }
}