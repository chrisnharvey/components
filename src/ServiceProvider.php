<?php

namespace Encore\Resource;

class ServiceProvider extends \Encore\Container\ServiceProvider
{
    public function commands()
    {
        return ['Encore\Resource\Command\Publish'];
    }
}