<?php

namespace Encore\Error;

use Symfony\Component\Debug\ErrorHandler;
use Encore\Container\ContainerAwareInterface;
use Encore\Container\ContainerAwareTrait;

class Handler implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function __construct(ExceptionDisplayerInterface $displayer)
    {
        $this->displayer = $displayer;
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
        ExceptionHandler::register(true, $this->container)
            ->setDisplayer($this->displayer);
    }
}