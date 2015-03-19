<?php

namespace Encore\Compiler;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function commands()
    {
        return ['Encore\Compiler\Command'];
    }
}