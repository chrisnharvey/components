<?php

use Encore\Error\ExceptionHandler;
use Encore\Error\Displayer\BasicDisplayer;

class BasicDisplayerTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->exceptionHandler = new ExceptionHandler;
        $this->exceptionHandler->setDisplayer(new BasicDisplayer);
    }

    public function testDisplayerCalled()
    {
        $exception = new ErrorException('foo');

        ob_start();
        $this->exceptionHandler->handle($exception);
        $response = ob_get_clean();

        $this->assertEquals($response, PHP_EOL.'foo'.PHP_EOL);
    }
}