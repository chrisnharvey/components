<?php

namespace Encore\Development\Command;

use Encore\Console\Command;
use Encore\Container\ContainerAwareTrait;
use Encore\Container\ContainerAwareInterface;

class Debug extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public $name = 'debug';
    public $description = 'Run the application in debug mode';

    public function fire()
    {
        require $this->container->appPath().'/start.php';

        $this->container['launcher'];
    }
}