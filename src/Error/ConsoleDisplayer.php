<?php

namespace Encore\Console\Error;

use Exception;
use Encore\Console\Application;
use Encore\Error\Displayer\DisplayerInterface;

class ConsoleDisplayer implements DisplayerInterface
{
    protected $console;

    /**
     * Construct the class and set some properties.
     *
     * @param Application $console
     */
    public function __construct(Application $console)
    {
        $this->console = $console;
    }

    /**
     * Display the uncaught exception
     * 
     * @param  Exception $exception
     * @return void
     */
    public function display(Exception $exception)
    {
        $this->console->renderException($exception);
    }
}