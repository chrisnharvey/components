<?php

namespace Encore\Database\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrationMigrate extends \Encore\Console\Command
{
    protected $name = 'migration:migrate';
    protected $description = 'Execute all pending migrations';

    /**
     * Fire the install command
     * 
     * @return void
     */
    public function fire()
    {
        
    }
}