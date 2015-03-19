<?php

namespace Encore\Container\Test\Stub;

class Qux
{
    public $bar;

    public function setBar(BarInterface $bar)
    {
        $this->bar = $bar;
    }
}
