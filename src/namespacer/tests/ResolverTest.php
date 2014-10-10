<?php

use Encore\Namespacer\Resolver;

class ResolverTest extends PHPUnit_Framework_TestCase
{
    public function testResolution()
    {
        $r = new Resolver;

        $this->assertEquals(array('foo', 'bar', 'baz'), $r->parseKey('foo::bar.baz'));
        $this->assertEquals(array('foo', 'bar', null), $r->parseKey('foo::bar'));
        $this->assertEquals(array(null, 'bar', 'baz'), $r->parseKey('bar.baz'));
        $this->assertEquals(array(null, 'bar', null), $r->parseKey('bar'));
    }


    public function testParsedItemsAreCached()
    {
        $r = $this->getMock('Encore\Namespacer\Resolver', array('parseBasicSegments', 'parseNamespacedSegments'));
        $r->setParsedKey('foo.bar', array('foo'));
        $r->expects($this->never())->method('parseBasicSegments');
        $r->expects($this->never())->method('parseNamespacedSegments');

        $this->assertEquals(array('foo'), $r->parseKey('foo.bar'));
    }
}