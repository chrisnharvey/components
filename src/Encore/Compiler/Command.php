<?php

namespace Encore\Compiler;

class Command extends \Encore\Console\Command
{
    protected $name = 'compile';
    protected $description = 'Compile the application for distribution';

    public function fire()
    {
        $this->info('It works!');
    }
}