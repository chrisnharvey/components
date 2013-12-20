<?php

namespace Encore\Testing;

class Command extends \Encore\Console\Command
{
    protected $name = 'test';
    protected $description = 'Run application unit tests';

    public function fire()
    {
        \PHPUnit_TextUI_Command::main(false);
    }
}