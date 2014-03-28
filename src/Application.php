<?php

namespace Encore\Console;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Application extends \Symfony\Component\Console\Application
{
    /**
     * Run an Artisan console command by name.
     *
     * @param  string  $command
     * @param  array   $parameters
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    public function call($command, array $parameters = array(), OutputInterface $output = null)
    {
        $parameters['command'] = $command;

        // Unless an output interface implementation was specifically passed to us we
        // will use the "NullOutput" implementation by default to keep any writing
        // suppressed so it doesn't leak out to the browser or any other source.
        $output = $output ?: new NullOutput;

        $input = new ArrayInput($parameters);

        return $this->find($command)->run($input, $output);
    }

    /**
     * Set whether the Console app should auto-exit when done.
     *
     * @param  bool  $boolean
     * @return \Illuminate\Console\Application
     */
    public function setAutoExit($boolean)
    {
        parent::setAutoExit($boolean);

        return $this;
    }

}
