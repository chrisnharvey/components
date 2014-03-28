<?php

namespace Encore\Container\Test\Stub;

class Foo
{
    public $bar;
    public $baz;

    public function __construct(BarInterface $bar, BazInterface $baz)
    {
        $this->bar = $bar;
        $this->baz = $baz;
    }
}
