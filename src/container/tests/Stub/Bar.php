<?php

namespace Encore\Container\Test\Stub;

class Bar implements BarInterface
{
    public $qux;

    public function __construct(Qux $qux)
    {
        $this->qux = $qux;
    }
}
