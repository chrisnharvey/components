<?php

namespace Encore\Testing;

class Command extends \Encore\Console\Command
{
    public $name = 'test';
    public $description = 'Run application unit tests';

    public function fire()
    {
        $_SERVER['argv'] = array_slice($_SERVER['argv'], 2);
        \PHPUnit_TextUI_Command::main(false);
    }
}