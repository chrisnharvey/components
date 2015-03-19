<?php

namespace Encore\Database\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateMigration extends \Encore\Console\Command
{
    protected $name = 'migration:generate';
    protected $description = 'Generate migrations based on schema changes';

    /**
     * Fire the install command
     * 
     * @return void
     */
    public function fire()
    {
        
    }
}