<?php

use Encore\Error\ExceptionHandler;

class ExceptionHandlerTest extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->displayer = Mockery::mock('Encore\Error\Displayer\DisplayerInterface');
        $this->handler = new ExceptionHandler;
        $this->handler->setDisplayer($this->displayer);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testDisplayerCalled()
    {
        $exception = new ErrorException;

        $this->displayer->shouldReceive('display')->once()->with($exception);

        $this->handler->handle($exception);
    }
}