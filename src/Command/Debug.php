<?php

namespace Encore\Development\Command;

use Encore\Console\Command;
use Encore\Container\ContainerAwareTrait;
use Encore\Container\ContainerAwareInterface;

class Debug extends Command implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    protected $name = 'debug';
    protected $description = 'Run the application in debug mode';

    /**
     * Execute the command
     * 
     * @return void
     */
    public function fire()
    {
        require $this->container->appPath().'/start.php';

        $this->container['launcher'];
    }
}