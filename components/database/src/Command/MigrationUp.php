<?php

namespace Encore\Database\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrationUp extends \Encore\Console\Command
{
    protected $name = 'migration:up';
    protected $description = 'Execute migrations up';

    /**
     * Fire the install command
     * 
     * @return void
     */
    public function fire()
    {
        
    }
}