<?php

namespace Encore\Testing;

class Command extends \Encore\Console\Command
{
    protected $name = 'test';
    protected $description = 'Run application unit tests';

    /**
     * Execute the command
     * 
     * @return void
     */
    public function fire()
    {
        $_SERVER['argv'] = array_slice($_SERVER['argv'], 2);
        \PHPUnit_TextUI_Command::main(false);
    }
}