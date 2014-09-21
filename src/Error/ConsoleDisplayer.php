<?php

namespace Encore\Console\Error;

use Encore\Console\Application;
use Encore\Error\Displayer\DisplayerInterface;

class ConsoleDisplayer implements DisplayerInterface
{
    protected $console;

    public function __construct(Application $console)
    {
        $this->console = $console;
    }

    public function display(\Exception $exception)
    {
        $this->console->renderException($exception);
    }
}