<?php

namespace Encore\Foundation\Provider;

class Collection extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->singleton('collection', function() {
            return new \Encore\Foundation\Collection;
        });
    }
}