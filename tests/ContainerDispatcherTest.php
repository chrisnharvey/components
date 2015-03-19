<?php

class ContainerDispatcherTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->emitter = Mockery::mock('Sabre\Event\EventEmitterInterface');
        $this->dispatcher = new Encore\Events\Dispatcher($this->emitter);
        $this->events = new Encore\Events\ContainerDispatcher($this->dispatcher);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testListen()
    {        
        $this->emitter->shouldReceive('on')->once();

        $this->events->listen('event', function() {});
    }
}