<?php

namespace Encore\Error;

use Exception;
use Symfony\Component\Debug\ExceptionHandler as BaseExceptionHandler;

class ExceptionHandler extends BaseExceptionHandler
{
    public function setDisplayer($displayer)
    {
        $this->displayer = $displayer;
    }

    /**
     * Registers the exception handler.
     *
     * @param bool    $debug
     *
     * @return ExceptionHandler The registered exception handler
     */
    public static function register($debug = true)
    {
        $handler = new static($debug);

        set_exception_handler(array($handler, 'handle'));

        return $handler;
    }

    public function handle(Exception $exception)
    {
        $this->displayer->display($exception);
    }
}