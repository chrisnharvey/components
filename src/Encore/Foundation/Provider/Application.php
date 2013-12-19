<?php

namespace Encore\Foundation\Provider;

use Encore\Foundation\Command\Run as RunCommand;

class Application extends \Encore\Foundation\ServiceProvider
{
    public function boot()
    {
        $this->app['console']->add(new RunCommand($this->app));
    }
}