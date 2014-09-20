<?php

namespace Encore\Error;

use Symfony\Component\Debug\ErrorHandler;
use Encore\Container\Container;

class Handler
{
	protected $container = null;

	public function __construct(ExceptionDisplayerInterface $displayer)
	{
		$this->displayer = $displayer;
	}

	public function setContainer(Container $container)
	{
		$this->container = $container;
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