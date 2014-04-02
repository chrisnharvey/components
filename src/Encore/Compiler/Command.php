<?php

namespace Encore\Compiler;

use Encore\Container\ContainerAwareTrait;
use Encore\Container\ContainerAwareInterface;
use Encore\Console\Command as BaseCommand;

class Command extends BaseCommand implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public $name = 'compile';
    public $description = 'Compile the application for distribution';
    protected $name = 'compile';
    protected $description = 'Compile the application for distribution';

    public function fire()
    {
        $this->info('It works!');
    }
}