<?php

class DispatcherTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->emitter = Mockery::mock('Sabre\Event\EventEmitterInterface');
        $this->dispatcher = new Encore\Events\Dispatcher($this->emitter);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testListen()
    {        
        $this->emitter->shouldReceive('on')->once();

        $this->dispatcher->listen('event', function() {});
    }

    public function testOnce()
    {
        $callback = function() {};

        $this->emitter->shouldReceive('once')
            ->with('event', $callback, 25)
            ->once();

        $this->dispatcher->once('event', $callback, 25);
    }

    public function testFire()
    {
        $this->emitter->shouldReceive('emit')
            ->with('event', ['hello'])
            ->once()
            ->andReturn('foo');

        $this->assertEquals($this->dispatcher->fire('event', ['hello']), 'foo');
    }

    public function testListeners()
    {
        $this->emitter->shouldReceive('listeners')
            ->with('event')
            ->once()
            ->andReturn(['foo']);

        $this->assertEquals($this->dispatcher->listeners('event'), ['foo']);
    }

    public function testForgetListener()
    {
        $callback = function() {};

        $this->emitter->shouldReceive('removeListener')
            ->with('event', $callback)
            ->once();

        $this->dispatcher->forgetListener('event', $callback);
    }

    public function testForget()
    {
        $this->emitter->shouldReceive('removeAllListeners')
            ->with('event')
            ->once();

        $this->dispatcher->forget('event');
    }
}