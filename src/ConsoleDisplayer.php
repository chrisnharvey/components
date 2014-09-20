<?php

namespace Encore\Error;

use Encore\Container\Container;
use Encore\Container\ContainerAwareInterface;
use Encore\Container\ContainerAwareTrait;

class ConsoleDisplayer implements ExceptionDisplayerInterface, ContainerAwareInterface
{
	use ContainerAwareTrait;

	public function display(\Exception $exception)
	{
        if ($this->container->bound('console')) {
		  return $this->container['console']->renderException($exception);
        }

        echo PHP_EOL.$exception->getMessage().PHP_EOL;
	}
}