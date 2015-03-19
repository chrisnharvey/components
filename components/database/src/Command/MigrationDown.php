<?php

namespace Encore\Database\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MigrationDown extends \Encore\Console\Command
{
    protected $name = 'migration:down';
    protected $description = 'Execute migrations down';

    /**
     * Fire the install command
     * 
     * @return void
     */
    public function fire()
    {
        
    }
}