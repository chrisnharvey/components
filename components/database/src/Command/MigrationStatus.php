<?php

namespace Encore\Database\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrationStatus extends \Encore\Console\Command
{
    protected $name = 'migration:status';
    protected $description = 'Get migration status';

    /**
     * Fire the install command
     * 
     * @return void
     */
    public function fire()
    {
        
    }
}