<?php

namespace Encore\View;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->app->instance('view', new Manager);
    }
}