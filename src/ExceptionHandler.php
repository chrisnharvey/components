<?php

namespace Encore\Error;

use Exception;
use Symfony\Component\Debug\ExceptionHandler as BaseExceptionHandler;

class ExceptionHandler extends BaseExceptionHandler
{
    /**
     * Set the exception displayer
     * 
     * @param DisplayerInterface $displayer
     */
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
    public static function register($debug = true, $charset = null, $fileLinkFormat = null)
    {
        $handler = new static($debug, $charset, $fileLinkFormat);

        set_exception_handler(array($handler, 'handle'));

        return $handler;
    }

    /**
     * Handle the exception and pass it to the displayer
     * 
     * @param  Exception $exception
     * @return void
     */
    public function handle(Exception $exception)
    {
        $this->displayer->display($exception);
    }
}
