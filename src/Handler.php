<?php

namespace Encore\Error;

use Encore\Error\Displayer\DisplayerInterface;
use Symfony\Component\Debug\ErrorHandler;
use Encore\Container\ContainerAwareInterface;
use Encore\Container\ContainerAwareTrait;

class Handler
{
    /**
     * Construct the exception handler
     * 
     * @param DisplayerInterface $displayer
     */
    public function __construct(DisplayerInterface $displayer)
    {
        $this->displayer = $displayer;
    }

    /**
     * Set the exception displayer
     * 
     * @param DisplayerInterface $displayer
     */
    public function setDisplayer(DisplayerInterface $displayer)
    {
        $this->displayer = $displayer;

        $this->exceptionHandler->setDisplayer($displayer);
    }

    /**
     * Register the error handler and the exception handler
     * 
     * @return void
     */
    public function register()
    {
        $this->registerErrorHandler();
        $this->registerExceptionHandler();
    }

    /**
     * Register the Symfony error handler
     * 
     * @return void
     */
    protected function registerErrorHandler()
    {
        ErrorHandler::register(E_ALL);
    }

    /**
     * Register the Symfony exception handler
     * 
     * @return void
     */
    protected function registerExceptionHandler()
    {
        $this->exceptionHandler = ExceptionHandler::register(true);
        $this->exceptionHandler->setDisplayer($this->displayer);
    }
}