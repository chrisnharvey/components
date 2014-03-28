<?php

namespace Encore\Container\Test\Stub;

class Corge
{
    public $int;

    public function __construct($int = null)
    {
        $this->int = $int;
    }

    public function setInt($int)
    {
        $this->int = $int;
    }
}
