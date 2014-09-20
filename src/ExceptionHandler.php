<?php

namespace Encore\Error;

use Encore\Container\Container;
use Symfony\Component\Debug\ExceptionHandler as BaseExceptionHandler;
use Encore\Container\ContainerAwareInterface;
use Encore\Container\ContainerAwareTrait;

class ExceptionHandler extends BaseExceptionHandler implements ContainerAwareInterface
{
    use ContainerAwareTrait;

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
    public static function register($debug = true, Container $container = null)
    {
        $handler = new static($debug);
        if ($container) $handler->setContainer($container);

        set_exception_handler(array($handler, 'handle'));

        return $handler;
    }

	public function handle(\Exception $exception)
	{
		$this->displayer->display($exception);
	}
}