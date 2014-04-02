<?php

namespace Encore\Development;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function commands()
    {
        return ['Encore\Development\Command\Debug'];
    }
}