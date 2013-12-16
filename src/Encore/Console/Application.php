<?php

/**
  * This class is a modified version of the Laravel
  * Illuminate\Console\Application class.
  */

namespace Encore\Console;

use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class Application extends \Symfony\Component\Console\Application
{
    /**
     * The exception handler instance.
     *
     * @var \Illuminate\Exception\Handler
     */
    protected $exceptionHandler;

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
     * Get the default input definitions for the applications.
     *
     * @return \Symfony\Component\Console\Input\InputDefinition
     */
    protected function getDefaultInputDefinition()
    {
        $definition = parent::getDefaultInputDefinition();

        $definition->addOption($this->getEnvironmentOption());

        return $definition;
    }

    /**
     * Get the global environment option for the definition.
     *
     * @return \Symfony\Component\Console\Input\InputOption
     */
    protected function getEnvironmentOption()
    {
        $message = 'The environment the command should run under.';

        return new InputOption('--env', null, InputOption::VALUE_OPTIONAL, $message);
    }

    /**
     * Render the given exception.
     *
     * @param  \Exception  $e
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    public function renderException($e, $output)
    {
        // If we have an exception handler instance, we will call that first in case
        // it has some handlers that need to be run first. We will pass "true" as
        // the second parameter to indicate that it's handling a console error.
        if (isset($this->exceptionHandler)) {
            $this->exceptionHandler->handleConsole($e);
        }

        parent::renderException($e, $output);
    }

    /**
     * Set the exception handler instance.
     *
     * @param  \Illuminate\Exception\Handler  $handler
     * @return \Illuminate\Console\Application
     */
    public function setExceptionHandler($handler)
    {
        $this->exceptionHandler = $handler;

        return $this;
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
