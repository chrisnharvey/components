<?php

namespace Encore\Error;

use Encore\Error\Displayer\DisplayerInterface;
use Symfony\Component\Debug\ErrorHandler;
use Encore\Container\ContainerAwareInterface;
use Encore\Container\ContainerAwareTrait;

class Handler
{
    public function __construct(DisplayerInterface $displayer)
    {
        $this->displayer = $displayer;
    }

    public function setDisplayer(DisplayerInterface $displayer)
    {
        $this->displayer = $displayer;

        $this->exceptionHandler->setDisplayer($displayer);
    }

    public function register()
    {
        $this->registerErrorHandler();
        $this->registerExceptionHandler();
    }

    protected function registerErrorHandler()
    {
        ErrorHandler::register(E_ALL);
    }

    protected function registerExceptionHandler()
    {
        $this->exceptionHandler = ExceptionHandler::register(true);
        $this->exceptionHandler->setDisplayer($this->displayer);
    }
}